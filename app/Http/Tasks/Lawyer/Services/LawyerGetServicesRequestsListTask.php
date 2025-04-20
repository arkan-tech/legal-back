<?php

namespace App\Http\Tasks\Lawyer\Services;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Client\ClientRequest;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestWithLawyerRequesterResource;

class LawyerGetServicesRequestsListTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = $this->authLawyer();
        $service_requests = LawyerServicesRequest::where('transaction_complete', 1)->where('request_lawyer_id', $lawyer->id)->orderBy('created_at', 'desc')->get();
        $service_requests = LawyerServicesRequestWithLawyerRequesterResource::collection($service_requests);
        return $this->sendResponse(true, ' طلباتي ', compact('service_requests'), 200);
    }
}
