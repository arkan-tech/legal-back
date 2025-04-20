<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Requests\API\Client\AdvisoryService\ClientDelayAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDates;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use App\Models\AdvisoryServices\ClientAdvisoryServicesAppointment;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\ClientReservations\ClientReservations;

class ClientDelayAdvisoryServiceReservationTask extends BaseTask
{

    public function run(ClientDelayAdvisoryServiceReservationRequest $request)
    {

        $client = $this->authClient();

        $advisory_services_reservation = ClientAdvisoryServicesReservations::with('service')->where('client_id', $client->id)->where('id', $request->client_advisory_services_reservation_id)->first();
        if ($advisory_services_reservation->reservation_status == 7) {
            return $this->sendResponse(false, 'عذراً , الاستشارة ملغية من قبل ', null, 404);
        }
        if ($advisory_services_reservation->service->need_appointment == 0) {
            return $this->sendResponse(false, 'عذراً , الاستشارة لا تحتاج الى موعد ', null, 404);
        }
        if (is_null($advisory_services_reservation)) {
            return $this->sendResponse(false, 'عذراً ,  حجز الاستشارة غير موجود ', null, 404);
        }
        if ($advisory_services_reservation->reservation_status == 3) {
            return $this->sendResponse(false, 'عذراً ,  لا يمكن تأجيل الموعد لان الموعد تم وانتهى وحالته الآن مكتمل  ', null, 422);
        }
        $ClientAdvisoryServicesAppointment = ClientAdvisoryServicesAppointment::where('client_id', $client->id)->pluck('client_advisory_services_reservation_id')->toArray();
        if (in_array($advisory_services_reservation->id, $ClientAdvisoryServicesAppointment)) {
            return $this->sendResponse(false, 'عذراً ,  لا يمكن تأجيل الموعد مرة اخرى لان الموعد تم تأجيله بالفعل , يمكنك تعديل الموعد لو اردت !  ', null, 422);
        }
        $advisory_services_dates_ids = AdvisoryServicesAvailableDates::where('advisory_services_id',$advisory_services_reservation->service->id)->pluck('id')->toArray();;
        $advisory_services_dates_times_ids = AdvisoryServicesAvailableDatesTimes::where('advisory_services_id',$advisory_services_reservation->service->id)
            ->where('advisory_services_available_dates_id',$request->date_id)->pluck('id')->toArray();
        if (!in_array($request->date_id,$advisory_services_dates_ids)){
            return $this->sendResponse(false, 'التاريخ غير متاح لهذه الاستشارة  ', null, 422);
        }

        if (!in_array($request->time_id,$advisory_services_dates_times_ids)){
            return $this->sendResponse(false, 'الوقت غير متاح لهذا التاريخ ', null, 422);
        }
        $date = AdvisoryServicesAvailableDates::where('advisory_services_id',$advisory_services_reservation->service->id)->where('id',$request->date_id)->first();
        $time = AdvisoryServicesAvailableDatesTimes::where('advisory_services_id',$advisory_services_reservation->service->id)
            ->where('advisory_services_available_dates_id',$request->date_id)->
            where('id',$request->time_id)
            ->first();

        $reservation = ClientAdvisoryServicesAppointment::create([
            'client_id' => $client->id,
            'client_advisory_services_reservation_id' => $advisory_services_reservation->id,
            'advisory_services_id' =>$advisory_services_reservation->service->id,
            'advisory_services_date_id' => $request->date_id,
            'advisory_services_time_id' => $request->time_id,
            'date'=>$date->date,
            'time_from'=>$time->time_from,
            'time_to'=>$time->time_to,
        ]);

        $Domain = route('site.index');
        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => '26601 - Ymtaz Company',
            'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
            'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
            'ivp_test' => '1',
            'ivp_amount' => $advisory_services_reservation->service->price,
            'ivp_currency' => 'SAR',
            'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
            'ivp_framed' => 1,
            'bill_country' => 'SA',
            'bill_email' => $client->email,
            'bill_fname' => $client->myname,
            'bill_sname' => $client->myname,
            'bill_city' => 'City',
            'bill_addr1' => 'City',
            'return_auth' => $Domain . '/api/client/advisory-services/complete/payment/' . $advisory_services_reservation->id,
            'return_can' => $Domain.'/api/client/advisory-services/cancel/payment/' . $advisory_services_reservation->id ,
            'return_decl' => $Domain.'/api/client/advisory-services/declined/payment/' . $advisory_services_reservation->id ,

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
        $advisory_services_reservation ->update([
            'transaction_id' => $results['order']['ref'],
        ]);
        $transaction_id = $results['order']['ref'];
        $payment_url = $results['order']['url'];
        $appointment_id = $reservation->id;
        return $this->sendResponse(true, 'تم انشاء الموعد وفي انتظار الدفع', compact('appointment_id','transaction_id','payment_url'), 200);
    }
}
