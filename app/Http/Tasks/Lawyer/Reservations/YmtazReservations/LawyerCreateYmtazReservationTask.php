<?php

namespace App\Http\Tasks\Lawyer\Reservations\YmtazReservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Client\Reservations\YmtazReservations\ClientCreateYmtazReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\YmtazReservations\LawyerCreateYmtazReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Client\Reservations\YmtazReservations\ClientYmtazReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\Service\Service;
use App\Models\YmtazReservations\YmtazLawyerReservations;
use App\Models\YmtazReservations\YmtazReservations;
use App\Models\YmtazSettings\YmtazWorkDayTimes;
use Exception;

class LawyerCreateYmtazReservationTask extends BaseTask
{

    public function run(LawyerCreateYmtazReservationRequest $request)
    {
        $lawyer = $this->authLawyer();

        $service = Service::where('id', $request->service_id)->first();
        $date_times = YmtazWorkDayTimes::where('ymtaz_available_dates_id', $request->ymtaz_date_id)->where('id', $request->ymtaz_date_id)->get();
        if (is_null($date_times)) {
            return $this->sendResponse(false, 'للاسف   التوقيت غير متاح', null, 404);
        }
        $reservation = YmtazLawyerReservations::create([
            'lawyer_id' => $lawyer->id,
            'service_id' => $request->service_id,
            'importance_id' => $request->importance_id,
            'description' => $request->description,
            'ymtaz_date_id' => $request->ymtaz_date_id,
            'ymtaz_time_id' => $request->ymtaz_time_id,
            'status' => 0,
            'price' => $service->ymtaz_price,
            'transaction_complete' => 0,
        ]);
        if ($request->has('file') && !is_null($request->file)) {
            $reservation->update([
                'file' => saveImage($request->file, 'uploads/ymtaz_reservations/'),
            ]);
        }
        $msg = ' في انتظار تأكيد الدفع';
        $Domain = route('site.index');
        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => '26601 - Ymtaz Company',
            'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
            'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
            'ivp_test' => '1',
            'ivp_amount' => $service->ymtaz_price,
            'ivp_currency' => 'SAR',
            'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
            'ivp_framed' => 1,
            'bill_country' => 'SA',
            'bill_email' => $lawyer->email,
            'bill_fname' => $lawyer->name,
            'bill_sname' => $lawyer->name,
            'bill_city' => 'City',
            'bill_addr1' => 'City',
            'return_auth' => $Domain . '/api/lawyer/reservations/ymtaz/complete/payment/' . $reservation->id,
            'return_can' => $Domain . '/api/lawyer/reservations/ymtaz/cancel/payment/' . $reservation->id,
            'return_decl' => $Domain . '/api/lawyer/reservations/ymtaz/declined/payment/' . $reservation->id,

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


        $reservation = new ClientYmtazReservationResource($reservation);
        return $this->sendResponse(true, $msg, compact('reservation', 'transaction_id', 'payment_url'), 200);
    }
}
