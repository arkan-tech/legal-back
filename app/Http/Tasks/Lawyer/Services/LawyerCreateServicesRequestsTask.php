<?php

namespace App\Http\Tasks\Lawyer\Services;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Tasks\BaseTask;
use App\Models\LawyerPayments;
use App\Models\Service\Service;
use App\Models\Client\ClientRequest;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\Service\ServiceYmtazLevelPrices;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Requests\API\Lawyer\Services\LawyerCreateServicesRequestsRequest;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;

class LawyerCreateServicesRequestsTask extends BaseTask
{

    public function run(LawyerCreateServicesRequestsRequest $request)
    {
        $lawyer = $this->authLawyer();
        $Service = Service::where('status', 1)->findOrFail($request->service_id);
        if ($request->has('lawyer_id') && !is_null($request->lawyer_id)) {
            if ($request->lawyer_id == $lawyer->id) {
                return $this->sendResponse(false, 'لا يمكنك طلب خدمة من نفسك', null, 404);
            }
            $services_ids = LawyersServicesPrice::where('lawyer_id', $request->lawyer_id)->get()->pluck('service_id')->toArray();
            if (!in_array($request->service_id, $services_ids)) {
                return $this->sendResponse(false, ' الخدمة غير متوفرة لهذا المحامي ', null, 404);
            }
            $service = LawyersServicesPrice::where('lawyer_id', $request->lawyer_id)->where('service_id', $request->service_id)->first();
            $price = $service->price;
        } else {
            $level = ServiceYmtazLevelPrices::where('service_id', $request->service_id)->where('request_level_id', $request->priority)->first();
            if (!is_null($level)) {
                $price = $level->price;
            } else {
                $price = $Service->ymtaz_price;
            }
        }
        if ($price == 0) {
            return $this->sendResponse(false, ' الخدمة سعرها 0 ريال وهذا غير مناسب للدفع  ', null, 402);
        }
        if ($Service->need_appointment == 1) {
            $date = Carbon::parse($request->date)->toDateString();
            $from = Carbon::parse($request->date . ' ' . $request->from);
            $to = Carbon::parse($request->date . ' ' . $request->to);
            if ($this->isTimeSlotReserved($from, $to, $date, $request->lawyer_id)) {
                return $this->sendResponse(false, 'Time slot is already booked.', null, 400);
            }
        }
        $service_request = LawyerServicesRequest::create([
            'request_lawyer_id' => $lawyer->id,
            'type_id' => $request->service_id,
            'priority' => $request->priority,
            'description' => $request->description,
            'for_admin' => $request->has('lawyer_id') && !is_null($request->lawyer_id) ? 2 : 1,
            'lawyer_id' => $request->has('lawyer_id') && !is_null($request->lawyer_id) ? $request->lawyer_id : null,
            'referral_status' => $request->has('lawyer_id') && !is_null($request->lawyer_id) ? 1 : 0,
            'payment_status' => 1,
            'price' => $price,
            'accept_rules' => $Service->accept_rules,
            'transaction_complete' => 0,
            "day" => $Service->need_appointment == 1 ? $date : null,
            "from" => $Service->need_appointment == 1 ? $from : null,
            "to" => $Service->need_appointment == 1 ? $to : null,
        ]);

        if ($request->has('file')) {
            $file = saveImage($request->file('file'), 'uploads/lawyer/service_request');
            $service_request->file = $file;
            $service_request->update();
        }


        $Domain = route('site.index');
        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => '26601 - Ymtaz Company',
            'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
            'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
            'ivp_test' => '1',
            'ivp_amount' => $price,
            'ivp_currency' => 'SAR',
            'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
            'ivp_framed' => 1,
            'bill_country' => 'SA',
            'bill_email' => $lawyer->email,
            'bill_fname' => $lawyer->name,
            'bill_sname' => $lawyer->name,
            'bill_city' => 'City',
            'bill_addr1' => 'City',
            'return_auth' => $Domain . '/api/payments/callback/lawyer/services/' . $service_request->id,
            'return_can' => $Domain . '/api/payments/callback/lawyer/services/' . $service_request->id,
            'return_decl' => $Domain . '/api/payments/callback/lawyer/services/' . $service_request->id,

        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $results = curl_exec($ch);

        if ($results === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        curl_close($ch);

        $results = json_decode($results, true);

        $service_request->update([
            'transaction_id' => $results['order']['ref'],
        ]);
        $transaction_id = $results['order']['ref'];
        $payment_url = $results['order']['url'];
        if (!is_null($request->lawyer_id)) {
            $payment = LawyerPayments::create([
                "lawyer_id" => $request->lawyer_id,
                "product_id" => $service_request->id,
                "product_type" => "service",
                'requester_type' => "lawyer"

            ]);
        }
        if ($Service->need_appointment == 1) {
            $httpClient = new Client();
            $jsonData = [
                "userType" => "lawyer",
                "userId" => $lawyer->id,
                "lawyerId" => $request->lawyer_id,
                "productId" => $service->id,
                "productType" => 2
            ];
            $httpRequest = $httpClient->postAsync(env('JS_API_URL') . 'get-stream/', [
                'json' => $jsonData
            ]);
            $httpRequest->wait();
        }
        $service_request = LawyerServicesRequest::find($service_request->id);
        $service_request = new LawyerServicesRequestResource($service_request);
        return $this->sendResponse(true, ' في انتظار تأكيد الدفع ', compact('service_request', 'transaction_id', 'payment_url'), 200);
    }
    protected function isTimeSlotReserved($start, $end, $date, $lawyer_id)
    {
        if (is_null($lawyer_id)) {
            $reservationsClient = ClientRequest::where('day', $date)->whereNull('lawyer_id')->get();
            $reservationsLawyer = LawyerServicesRequest::where('day', $date)->whereNull('lawyer_id')->get();
        } else {
            $reservationsClient = ClientRequest::where('day', $date)->where('lawyer_id', $lawyer_id)->get();
            $reservationsLawyer = LawyerServicesRequest::where('day', $date)->where('lawyer_id', $lawyer_id)->get();
        }
        $reservations = $reservationsClient->merge($reservationsLawyer);
        \Log::info('Checking time slot reservation', [
            'start' => $start->format('Y-m-d H:i:s'),
            'end' => $end->format('Y-m-d H:i:s'),
            'reservation_count' => $reservations->count(),
        ]);
        foreach ($reservations as $reservation) {
            $resFrom = Carbon::parse($date . ' ' . Carbon::parse($reservation->from)->format('H:i:s'));
            $resTo = Carbon::parse($date . ' ' . Carbon::parse($reservation->to)->format('H:i:s'));
            $isBetween = $start->between($resFrom, $resTo) || $end->between($resFrom, $resTo) || $resFrom->between($start, $end) || $resTo->between($start, $end);
            \Log::info('Checking against reservation', [
                'res_from' => $resFrom->format('Y-m-d H:i:s'),
                'res_to' => $resTo->format('Y-m-d H:i:s'),
            ]);
            if ($isBetween) {
                if ($reservation->transaction_complete != 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
