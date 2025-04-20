<?php

namespace App\Http\Tasks\Client\ServicesReservations;

use App\Http\Requests\API\Client\Services\ClientCreateServicesRequestsRequest;
use App\Http\Requests\API\Client\ServicesReservations\ClientCreateServicesReservationsLawyerRequest;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Resources\API\Client\Reservations\ClientLawyerReservationsResource;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\Client\ClientLawyerReservations;
use App\Models\Client\ClientRequest;
use App\Models\ElectronicOffice\Services\Services;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\Service\Service;
use Exception;
use Illuminate\Support\Facades\Crypt;

class ClientCreateServicesReservationsLawyerTask extends BaseTask
{

    public function run(ClientCreateServicesReservationsLawyerRequest $request)
    {
        $client = $this->authClient();
        $lawyer = Lawyer::where('id', $request->lawyer_id)->first();
        if ($lawyer->office_request_status == 0) {
            return $this->sendResponse(false, 'عذرا, القنوات الرقمية غير مفعلة لهذا الحساب مؤقتا ', null, 401);
        }
        $service = LawyersServicesPrice::where('lawyer_id', $request->lawyer_id)->where('service_id', $request->service_id)->first();

        if (is_null($service)) {
            return $this->sendResponse(false, 'عذرا, هذه الخدمة غير مخصصة لمقدم الخدمة الذي تم اختياره ', null, 401);
        }

        $reservation = ClientLawyerReservations::create([
            'client_id' => $client->id,
            'lawyer_id' => $request->lawyer_id,
            'service_id' => $request->service_id,
            'importance_id' => $request->importance_id,
            'description' => $request->description,
            'date_id' => $request->lawyer_date_id,
            'time_id' => $request->lawyer_time_id,
            'price' => $service->price,
            'transaction_complete' => 0,
            'complete_status' => 0,
        ]);
        if ($request->has('file') && !is_null($request->file)) {
            $reservation->update([
                'file' => saveImage($request->file('file'), 'uploads/client/reservations/lawyers/')
            ]);
        }
        $Domain = route('site.index');
        $orderNumber = "ORD-serv-" . $reservation->id;
        // $params = array(
        //     'ivp_method' => 'create',
        //     'ivp_store' => '26601 - Ymtaz Company',
        //     'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
        //     'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
        //     'ivp_test' => '1',
        //     'ivp_amount' => $reservation->price,
        //     'ivp_currency' => 'SAR',
        //     'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
        //     'ivp_framed' => 1,
        //     'bill_country' => 'SA',
        //     'bill_email' => $client->email,
        //     'bill_fname' => $client->myname,
        //     'bill_sname' => $client->myname,
        //     'bill_city' => 'City',
        //     'bill_addr1' => 'City',
        //     'return_auth' => $Domain . '/api/client/lawyer/reservations/complete/payment/' . $reservation->id,
        //     'return_can' => $Domain . '/api/client/lawyer/reservations/cancel/payment/' . $reservation->id,
        //     'return_decl' => $Domain . '/api/client/lawyer/reservations/declined/payment/' . $reservation->id,
        // );

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        // curl_setopt($ch, CURLOPT_POST, count($params));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        // $results = curl_exec($ch);

        // if ($results === false) {
        //     throw new Exception(curl_error($ch), curl_errno($ch));
        // }

        // curl_close($ch);

        // $results = json_decode($results, true);
        $data = [
            'amount' =>  $reservation->price,
            'description' => $request->description,
            'userId' => $client->id,
            'serviceCate' => 'advisory-service',
            'serviceId' => $request->service_id,
            'requester_type' => 'client',
            'orderNumber' => $orderNumber,

        ];
        $encryptedData = Crypt::encrypt(json_encode($data));
        $transaction_id = $orderNumber;

        $payment_url = route('payment.showForm', ['data' => $encryptedData]);
        $reservation->update([
            'transaction_id' => $transaction_id,
        ]);
        // $transaction_id = $results['order']['ref'];
        // $payment_url = $results['order']['url'];



        $reservation = new ClientLawyerReservationsResource($reservation);
        return $this->sendResponse(true, ' في انتظار تأكيد الدفع ', compact('reservation', 'payment_url', 'transaction_id'), 200);
    }
}