<?php

namespace App\Http\Tasks\Lawyer\Services;

use App\Http\Requests\API\Lawyer\Services\LawyerRateServicesRequestsRequest;
use App\Http\Tasks\BaseTask;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Models\LawyerServicesRequest\LawyerServicesRequestRates;

class LawyerRateServicesRequestsTask extends BaseTask
{

    public function run(LawyerRateServicesRequestsRequest $request)
    {
        $lawyer = $this->authLawyer();
        $reservation = LawyerServicesRequest::where('request_lawyer_id', $lawyer->id)->where('id', $request->client_service_request_id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, '! الطلب غير موجود ', null, 404);
        }
        if ($reservation->request_status != 2) {
            return $this->sendResponse(false, '! الطلب غير مكتمل بعد ', null, 402);
        }
        $reservations_rates = LawyerServicesRequestRates::where('lawyer_id', $lawyer->id)->where('lawyer_service_request_id', $request->client_service_request_id)->first();
        if (is_null($reservations_rates)) {
            LawyerServicesRequestRates::create([
                'lawyer_service_request_id' => $request->client_service_request_id,
                'lawyer_id' => $lawyer->id,
                'rate' => $request->rate,
                'comment' => $request->comment
            ]);
            return $this->sendResponse(true, 'تم تقييم الطلب بنجاح ', null, 200);

        } else {
            return $this->sendResponse(false, 'تم تقييم الطلب من قبل', null, 402);

        }
    }
}
