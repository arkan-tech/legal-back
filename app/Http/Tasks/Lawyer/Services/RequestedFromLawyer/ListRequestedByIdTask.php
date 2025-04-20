<?php

namespace App\Http\Tasks\Lawyer\Services\RequestedFromLawyer;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Client\ClientRequest;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestWithLawyerRequesterResource;

class ListRequestedByIdTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $lawyer = $this->authLawyer();
        $service_request = ClientRequest::where('transaction_complete', 1)->where('lawyer_id', $lawyer->id)->orderBy('created_at', 'desc')->findOrFail($id);
        if (is_null($service_request)) {
            $service_request = LawyerServicesRequest::where('transaction_complete', 1)->where('lawyer_id', $lawyer->id)->orderBy('created_at', 'desc')->findOrFail($id);

            $service_requests = new LawyerServicesRequestWithLawyerRequesterResource($service_request);
        } else {

            $service_requests = new ClientRequestResource($service_request);
        }

        return $this->sendResponse(true, 'الطلب', compact('service_request'), 200);
    }
}
