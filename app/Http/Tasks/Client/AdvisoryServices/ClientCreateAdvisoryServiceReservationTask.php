<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategoryPrice;
use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Tasks\BaseTask;
use App\Models\LawyerPayments;
use App\Models\Service\Service;
use App\Models\AdvisoryServicesReservations;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDates;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;
use App\Models\AdvisoryServices\ClientAdvisoryServicesAppointment;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Requests\API\Client\AdvisoryService\ClientCreateAdvisoryServiceReservationRequest;
use Illuminate\Support\Facades\Crypt;

class ClientCreateAdvisoryServiceReservationTask extends BaseTask
{

    public function run(ClientCreateAdvisoryServiceReservationRequest $request)
    {
        $client = $this->authAccount();
        $advisory = AdvisoryServicesSubCategoryPrice::where('id', $request->sub_price_id)->with('subCategory.generalCategory.paymentCategoryType')->first();
        if (!$advisory) {
            return $this->sendResponse(false, 'السعر غير موجودة', null, 400);
        }
        // $payment_method = AdvisoryServicesPaymentCategory::where('id', $advisory->advisoryService->payment_category_id)->first();
        // if ($payment_method->payment_method == 2 && count($advisory->advisory_services_prices) == 0) {
        // 	return $this->sendResponse(false, 'الخدمة مدفوعة و مستوى الخدمة غير موجود', null, 400);
        // }

        if ($advisory->price == 0) {
            return $this->sendResponse(false, 'الخدمة مدفوعة و مستوى الخدمة ليس له سعر', null, 400);
        }
        $date = null;
        $from = null;
        $to = null;
        if ($advisory->subCategory->generalCategory->paymentCategoryType->requires_appointment == 1) {
            $date = Carbon::parse($request->date)->toDateString();
            $from = Carbon::parse($request->date . ' ' . $request->from);
            $to = Carbon::parse($request->date . ' ' . $request->to);

            if ($this->isTimeSlotReserved($from, $to, $date, $request->lawyer_id)) {
                return $this->sendResponse(false, 'Time slot is already booked.', null, 400);
            }
        }
        // if ($payment_method->payment_method == 2) {
        $reservation = AdvisoryServicesReservations::create([
            'account_id' => $client->id,
            'sub_category_id' => $advisory->subCategory->id,
            'sub_category_price_id' => $advisory->id,
            'description' => $request->description,
            'payment_status' => 0,
            'transaction_complete' => 0,
            'for_admin' => !is_null($request->lawyer_id) ? 2 : 1,
            'reservation_status' => !is_null($request->lawyer_id) ? 2 : 1,
            'price' => $advisory->price,
            'from' => $from,
            'to' => $to,
            'day' => $date,
            'reserved_from_lawyer_id' => $request->lawyer_id ?? null,
            'accept_date' => date("Y-m-d"),
        ]);

        // Save files if present
        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = saveImage($file, 'uploads/advisory_services/reservations/');
                // Attach the file path to the reservation
                $reservation->files()->create(['file' => $filePath]);
            }
        }

        // Save voice file if present
        if ($request->hasFile('voice_file')) {
            $voiceFilePath = saveImage($request->file('voice_file'), 'uploads/advisory_services/reservations/');
            $reservation->files()->create(['file' => $voiceFilePath, 'is_voice' => 1]);
        }

        $Domain = route('site.index');
        $splittedName = explode(' ', $client->name);
        $firstName = $splittedName[0];
        $lastName = $splittedName[count($splittedName) - 1];
        $orderNumber = "ORD-ADVS-" . $reservation->id;
        $params = array(
            'action' => 'SALE',
            'edfa_merchant_id' => "05084137-f149-4fa3-bc14-492d13e3b6dd",
            "order_id" => $orderNumber,
            "order_amount" => $advisory->price,
            "order_currency" => "SAR",
            "order_description" => "Order for a customer",
            "req_token" => "N",
            "payer_first_name" => $firstName,
            "payer_last_name" => $lastName,
            'payer_address' => $client->email,
            "payer_country" => "SA",
            "payer_zip" => "12221",
            "payer_email" => $client->email,
            "payer_phone" => $client->phone,
            "payer_ip" => "127.0.0.1",
            "term_url_3ds" => $Domain . '/api/payments/callback/account/advisory-services/' . $reservation->id,
            "auth" => "N",
            "recurring_init" => "N",
            "hash" => sha1(md5(strtoupper($orderNumber . $advisory->price . "SAR" . "Order for a customer" . "d6c2ea8fb0df4efa00be1014dba3c806")))
        );


        $data = [
            'amount' =>  $advisory->price,
            'description' => 'Order for a customer',
            'userId' => $client->id,
            'serviceCate' => 'advisory-service',
            'serviceId' => $advisory->id,
            'requester_type' => 'client',
            'orderNumber' => $orderNumber,

        ];
        $encryptedData = Crypt::encrypt(json_encode($data));
        $transaction_id = $orderNumber;

        $payment_url = route('payment.showForm', ['data' => $encryptedData]);


        $reservation->update([
            'transaction_id' => $transaction_id,
        ]);
        if (!is_null($request->lawyer_id)) {
            $payment = LawyerPayments::create([
                "account_id" => $request->lawyer_id,
                "product_id" => $reservation->id,
                "product_type" => "advisory-service",
                'requester_type' => $client->account_type
            ]);
        }
        $msg = ' في انتظار تأكيد الدفع';

        if ($advisory->subCategory->generalCategory->paymentCategoryType->requires_appointment == 1) {

            $httpClient = new Client();
            $jsonData = [
                "userId" => $client->id,
                "lawyerId" => !is_null($request->lawyer_id) ? $request->lawyer_id : null,
                "productId" => $reservation->id,
                "productType" => 3
            ];
            $httpRequest = $httpClient->postAsync(env('JS_API_URL') . 'get-stream/', [
                'json' => $jsonData
            ]);
            $httpRequest->wait();
        }
        $reservation = AdvisoryServicesReservations::find($reservation->id);
        $reservation = new AdvisoryServicesReservationResource($reservation);
        return $this->sendResponse(true, $msg, compact('reservation', 'transaction_id', 'payment_url'), 200);
        // TODO Make it take from the package if he is on a package and his package has in limit instead of paying
    }
    protected function isTimeSlotReserved($start, $end, $date, $lawyer_id)
    {
        $reservations = AdvisoryServicesReservations::where('day', $date)->where('reserved_from_lawyer_id', $lawyer_id)->get();
        foreach ($reservations as $reservation) {
            $resFrom = Carbon::parse($date . ' ' . Carbon::parse($reservation->from)->format('H:i:s'));
            $resTo = Carbon::parse($date . ' ' . Carbon::parse($reservation->to)->format('H:i:s'));
            $isBetween = $start->between($resFrom, $resTo) || $end->between($resFrom, $resTo) || $resFrom->between($start, $end) || $resTo->between($start, $end);
            if ($isBetween) {
                // Add a cronjob that checks if the reservation is not paid after 30 minutes, cancel it and remove the below condition
                if ($reservation->transaction_complete != 0) {
                    return true;
                }
            }
        }

        return false;
    }
}