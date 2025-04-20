<?php

namespace App\Http\Tasks\Lawyer\Services;

use App\Http\Requests\API\Lawyer\Services\LawyerCreateServicesRequestsRequest;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Models\Service\Service;
use App\Models\Service\ServiceYmtazLevelPrices;
use Exception;

class LawyerCreateLawyerServicesRequestsTask extends BaseTask
{

    public function run(LawyerCreateServicesRequestsRequest $request)
    {
        $lawyer = $this->authLawyer();
        $Service = Service::where('status', 1)->findOrFail($request->service_id);
        if ($request->has('lawyer_id') && !is_null($request->lawyer_id)){
            $services_ids = LawyersServicesPrice::where('lawyer_id',$request->lawyer_id)->get()->pluck('service_id')->toArray();
            if (!in_array($request->service_id,$services_ids)){
                return $this->sendResponse(false, ' الخدمة غير متوفرة لهذا المحامي ',null, 404);
            }
            $service = LawyersServicesPrice::where('lawyer_id',$request->lawyer_id)->where('service_id',$request->service_id)->first();
            $price = $service->price;
        }else{
            $level= ServiceYmtazLevelPrices::where('service_id',$request->service_id)->where('request_level_id',$request->priority)->first();
            if (!is_null($level)){
                $price = $level->price;
            }else{
                $price = $Service->ymtaz_price;
            }

        }
        if ($price == 0){
            return $this->sendResponse(false, ' الخدمة سعرها 0 ريال وهذا غير مناسب للدفع  ',null, 402);
        }

        $service_request = LawyerServicesRequest::create([
            'request_lawyer_id' => $lawyer->id,
            'type_id' => $request->service_id,
            'priority' => $request->priority,
            'description' => $request->description,
            'for_admin' => $request->has('lawyer_id')&&!is_null($request->lawyer_id)?2: 1,
            'lawyer_id' => $request->has('lawyer_id')&&!is_null($request->lawyer_id)?$request->lawyer_id: null,
            'referral_status' => $request->has('lawyer_id')&&!is_null($request->lawyer_id)?2: 1,
            'payment_status' => 1,
            'price' => $price,
            'accept_rules' => $Service->accept_rules,
            'transaction_complete' => 0,
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
            'return_auth' => $Domain . '/api/lawyer/services-request/complete/payment/' . $service_request->id,
            'return_can' => $Domain . '/api/lawyer/services-request/cancel/payment/' . $service_request->id,
            'return_decl' => $Domain . '/api/lawyer/services-request/declined/payment/' . $service_request->id,

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

        $service_request = new LawyerServicesRequestResource($service_request);
        return $this->sendResponse(true, ' في انتظار تأكيد الدفع ', compact('service_request', 'transaction_id', 'payment_url'), 200);
    }
}
