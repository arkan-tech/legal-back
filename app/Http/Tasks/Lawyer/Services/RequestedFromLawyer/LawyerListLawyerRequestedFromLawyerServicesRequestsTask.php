<?php

namespace App\Http\Tasks\Lawyer\Services\RequestedFromLawyer;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Client\ClientRequest;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestWithLawyerRequesterResource;

class LawyerListLawyerRequestedFromLawyerServicesRequestsTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = $this->authLawyer();
        $service_requests = LawyerServicesRequest::where('transaction_complete', 1)->where('lawyer_id', $lawyer->id)->orderBy('created_at', 'desc')->with('requesterLawyer')->get();
        $service_requests = LawyerServicesRequestWithLawyerRequesterResource::collection($service_requests);
        return $this->sendResponse(true, ' طلبات التي طلبها مقدمي الخدمة ', compact('service_requests'), 200);
    }
}
