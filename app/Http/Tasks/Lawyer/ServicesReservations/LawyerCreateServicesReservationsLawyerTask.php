<?php

namespace App\Http\Tasks\Lawyer\ServicesReservations;


use Exception;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\Client\ClientLawyerReservations;
use App\Models\Lawyer\LawyerReservationsLawyer;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\Client\Reservations\ClientLawyerReservationsResource;
use App\Http\Resources\API\Lawyer\Reservations\LawyerReservationsLawyerResource;
use App\Http\Requests\API\Lawyer\ServicesReservations\LawyerCreateServicesReservationsLawyerRequest;

class LawyerCreateServicesReservationsLawyerTask extends BaseTask
{

    public function run(LawyerCreateServicesReservationsLawyerRequest $request)
    {
        $client = $this->authLawyer();
        $lawyer = Lawyer::where('id', $request->lawyer_id)->first();
        $service = LawyersServicesPrice::where('lawyer_id', $request->lawyer_id)->where('service_id', $request->service_id)->where($request->importance_id)->first();
        if (is_null($service)) {
            return $this->sendResponse(false, 'عذرا, هذه الخدمة غير مخصصة لمقدم الخدمة الذي تم اختياره ', null, 401);
        }

        $reservation = LawyerServicesRequest::create([
            'request_lawyer_id' => $client->id,
            'type_id' => $request->service_id,
            'priority' => $request->importance_id,
            'description' => $request->description,
            // 'date_id' => $request->lawyer_date_id,
            // 'time_id' => $request->lawyer_time_id,
            'price' => $service->price,
            'transaction_complete' => 0,
            'complete_status' => 0,
        ]);
        if ($request->has('file') && !is_null($request->file)) {
            $reservation->update([
                'file' => saveImage($request->file('file'), 'uploads/lawyer/reservations/lawyers/')
            ]);
        }
        $Domain = route('site.index');
        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => '26601 - Ymtaz Company',
            'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
            'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
            'ivp_test' => '1',
            'ivp_amount' => $reservation->price,
            'ivp_currency' => 'SAR',
            'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
            'ivp_framed' => 1,
            'bill_country' => 'SA',
            'bill_email' => $client->email,
            'bill_fname' => $client->myname,
            'bill_sname' => $client->myname,
            'bill_city' => 'City',
            'bill_addr1' => 'City',
            'return_auth' => $Domain . '/api/lawyer/lawyer/reservations/complete/payment/' . $reservation->id,
            'return_can' => $Domain . '/api/lawyer/lawyer/reservations/cancel/payment/' . $reservation->id,
            'return_decl' => $Domain . '/api/lawyer/lawyer/reservations/declined/payment/' . $reservation->id,
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
        $reservation = new LawyerReservationsLawyerResource($reservation);
        return $this->sendResponse(true, ' في انتظار تأكيد الدفع ', compact('reservation', 'payment_url', 'transaction_id'), 200);
    }
}
