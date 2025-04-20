<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices\Lawyer;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\LawyerPayments;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDates;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesAppointment;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationResource;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\Lawyer\LawyerCreateReservationLawyerRequest;

class LawyerCreateLawyerReservationTask extends BaseTask
{

    public function run(LawyerCreateReservationLawyerRequest $request)
    {
        $Lawyer = $this->authLawyer();
        $lawyer = Lawyer::where('id', $request->lawyer_id)->first();
        // if ($lawyer->office_request_status == 0) {
        //     return $this->sendResponse(false, 'عذرا, القنوات الرقمية غير مفعلة لهذا الحساب مؤقتا ', null, 401);
        // }
        $advisory = AdvisoryServicesTypes::where('id', $request->type_id)->with('advisory_services_prices', function ($query) use ($request) {
            $query->where('client_reservations_importance_id', $request->importance_id);
        })->with('advisoryService')->first();
        $payment_method = AdvisoryServicesPaymentCategory::where('id', $advisory->advisoryService->payment_category_id)->first();
        if ($payment_method->payment_method == 2 && count($advisory->advisory_services_prices) == 0) {
            return $this->sendResponse(false, 'الخدمة مدفوعة و مستوى الخدمة غير موجود', null, 400);
        }




        if ($advisory->need_appointment == 1) {
            $date = Carbon::parse($request->date)->toDateString();
            $from = Carbon::parse($request->date . ' ' . $request->from);
            $to = Carbon::parse($request->date . ' ' . $request->to);
            if ($this->isTimeSlotReserved($from, $to, $date, $request->lawyer_id)) {
                return $this->sendResponse(false, 'Time slot is already booked.', null, 400);
            }
            if ($payment_method->payment_method == 2) {
                $reservation = LawyerAdvisoryServicesReservations::create([
                    'reserved_lawyer_id' => $Lawyer->id,
                    'advisory_services_id' => $request->advisory_services_id,
                    'type_id' => $request->type_id,
                    'importance_id' => $request->importance_id,
                    'description' => $request->description,
                    'accept_rules' => 1,
                    'lawyer_id' => $request->lawyer_id,
                    'payment_status' => 0,
                    'transaction_complete' => 0,
                    'reservation_status' => 2,
                    'price' => $advisory->advisory_services_prices[0]->price,
                    'accept_date' => date("Y-m-d"),
                    'from' => $from,
                    'to' => $to,
                    'day' => $date,
                ]);

                $Domain = route('site.index');
                $params = array(
                    'ivp_method' => 'create',
                    'ivp_store' => '26601 - Ymtaz Company',
                    'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
                    'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
                    'ivp_test' => '1',
                    'ivp_amount' => $advisory->advisory_services_prices[0]->price,
                    'ivp_currency' => 'SAR',
                    'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
                    'ivp_framed' => 1,
                    'bill_country' => 'SA',
                    'bill_email' => $Lawyer->email,
                    'bill_fname' => $Lawyer->myname,
                    'bill_sname' => $Lawyer->myname,
                    'bill_city' => 'City',
                    'bill_addr1' => 'City',
                    'return_auth' => $Domain . '/api/payments/callback/lawyer/advisory-services/' . $reservation->id,
                    'return_can' => $Domain . '/api/payments/callback/lawyer/advisory-services/' . $reservation->id,
                    'return_decl' => $Domain . '/api/payments/callback/lawyer/advisory-services/' . $reservation->id,

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
                    throw new \Exception(curl_error($ch), curl_errno($ch));
                }

                curl_close($ch);
                $results = json_decode($results, true);


                $reservation->update([
                    'transaction_id' => $results['order']['ref'],
                ]);
                $transaction_id = $results['order']['ref'];
                $payment_url = $results['order']['url'];
                $msg = ' في انتظار تأكيد الدفع';

            } else if ($payment_method->payment_method == 1) {
                $msg = ' تم الحجز مجاناً بنجاح';
                $reservation = LawyerAdvisoryServicesReservations::create([
                    'reserved_lawyer_id' => $Lawyer->id,
                    'advisory_services_id' => $request->advisory_services_id,
                    'type_id' => $request->type_id,
                    'importance_id' => $request->importance_id,
                    'description' => $request->description,
                    'accept_rules' => 1,
                    'lawyer_id' => $request->lawyer_id,
                    'payment_status' => 1,
                    'transaction_complete' => 1,
                    'reservation_status' => 2,
                    'price' => null,
                    'accept_date' => date("Y-m-d"),
                    'from' => $from,
                    'to' => $to,
                    'day' => $date,
                ]);
                $transaction_id = null;
                $payment_url = null;
            }
        } else {
            $reservation = LawyerAdvisoryServicesReservations::create([
                'reserved_lawyer_id' => $Lawyer->id,
                'advisory_services_id' => $request->advisory_services_id,
                'type_id' => $request->type_id,
                'importance_id' => $request->importance_id,
                'description' => $request->description,
                'accept_rules' => 1,
                'lawyer_id' => $request->lawyer_id,
                'payment_status' => 0,
                'transaction_complete' => 0,
                'reservation_status' => 2,
                'price' => $payment_method->payment_method == 2 ? $advisory->advisory_services_prices[0]->price : 0,
                'accept_date' => date("Y-m-d"),
            ]);
            if ($payment_method->payment_method == 2) {
                $msg = ' في انتظار تأكيد الدفع';
                $Domain = route('site.index');
                $params = array(
                    'ivp_method' => 'create',
                    'ivp_store' => '26601 - Ymtaz Company',
                    'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
                    'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
                    'ivp_test' => '1',
                    'ivp_amount' => $advisory->advisory_services_prices[0]->price,
                    'ivp_currency' => 'SAR',
                    'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
                    'ivp_framed' => 1,
                    'bill_country' => 'SA',
                    'bill_email' => $Lawyer->email,
                    'bill_fname' => $Lawyer->myname,
                    'bill_sname' => $Lawyer->myname,
                    'bill_city' => 'City',
                    'bill_addr1' => 'City',
                    'return_auth' => $Domain . '/api/payments/callback/lawyer/advisory-services/' . $reservation->id,
                    'return_can' => $Domain . '/api/payments/callback/lawyer/advisory-services/' . $reservation->id,
                    'return_decl' => $Domain . '/api/payments/callback/lawyer/advisory-services/' . $reservation->id,

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
                $reservation->update([
                    'transaction_id' => $results['order']['ref'],
                ]);
                $transaction_id = $results['order']['ref'];
                $payment_url = $results['order']['url'];

            } else if ($payment_method->payment_method == 3) {
                $reservations_count = LawyerAdvisoryServicesReservations::where('lawyer_id', $Lawyer->id)->where('advisory_services_id', $request->advisory_services_id)->count();
                $payment_method_count = $payment_method->count;

                if ($reservations_count > $payment_method_count) {
                    $msg = '  في انتظار تأكيد الدفع';
                    $Domain = route('site.index');
                    $params = array(
                        'ivp_method' => 'create',
                        'ivp_store' => '26601 - Ymtaz Company',
                        'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
                        'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
                        'ivp_test' => '1',
                        'ivp_amount' => $payment_method->price,
                        'ivp_currency' => 'SAR',
                        'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
                        'ivp_framed' => 1,
                        'bill_country' => 'SA',
                        'bill_email' => $Lawyer->email,
                        'bill_fname' => $Lawyer->myname,
                        'bill_sname' => $Lawyer->myname,
                        'bill_city' => 'City',
                        'bill_addr1' => 'City',
                        'return_auth' => $Domain . '/api/payments/callback/lawyer/advisory-services/' . $reservation->id,
                        'return_can' => $Domain . '/api/payments/callback/lawyer/advisory-services/' . $reservation->id,
                        'return_decl' => $Domain . '/api/payments/callback/lawyer/advisory-services/' . $reservation->id,

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
                    $reservation->update([
                        'transaction_id' => $results['order']['ref'],
                    ]);
                    $transaction_id = $results['order']['ref'];
                    $payment_url = $results['order']['url'];

                } else {
                    $available_times = $payment_method_count - $reservations_count;
                    $msg = ' متبقي لك عدد : ' . $available_times . '  مرات للحجز ';
                    $transaction_id = null;
                    $payment_url = null;
                }
            } else if ($payment_method->payment_method == 1) {
                $msg = ' تم الحجز مجاناً بنجاح';
                $reservation->update([
                    'transaction_complete' => 1,
                    'price' => null,
                    'payment_status' => 1
                ]);
                $transaction_id = null;
                $payment_url = null;
            }



        }
        if ($advisory->advisoryService->need_appointment) {

            $httpClient = new Client();
            $jsonData = [
                "userType" => "lawyer",
                "userId" => $Lawyer->id,
                "lawyerId" => $lawyer->id,
                "productId" => $reservation->id,
                "productType" => 3
            ];
            $httpRequest = $httpClient->postAsync(env('JS_API_URL') . 'get-stream/', [
                'json' => $jsonData
            ]);
            $httpRequest->wait();
        }
        if (array_key_exists('file', $request->all()) == true) {
            $reservation->update([
                'file' => saveImage($request->file, 'uploads/advisory_services/reservations/')
            ]);
        }
        $reservation = LawyerAdvisoryServicesReservations::find($reservation->id);

        $reservation = new LawyerAdvisoryServicesReservationResource($reservation);

        $payment = LawyerPayments::create([
            "lawyer_id" => $lawyer->id,
            "product_id" => $reservation->id,
            "product_type" => "advisory-service",
            'requester_type' => "lawyer"
        ]);
        return $this->sendResponse(true, $msg, compact('reservation', 'transaction_id', 'payment_url'), 200);

    }
    protected function isTimeSlotReserved($start, $end, $date, $lawyer_id)
    {
        $reservationsLawyer = LawyerAdvisoryServicesReservations::where('day', $date)->whereNull('lawyer_id')->get();
        $reservationsClient = ClientAdvisoryServicesReservations::where('day', $date)->whereNull('lawyer_id')->get();
        $reservations = $reservationsLawyer->merge($reservationsClient);
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
