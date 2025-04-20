<?php

namespace App\Http\Tasks\Lawyer\Services\RequestedFromLawyer;

use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;
use App\Http\Resources\ServicesReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientRequest;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Models\Service\ServicesRequest;
use App\Models\ServicesReservations;
use Illuminate\Http\Request;

class LawyerListRequestedFromLawyerServicesRequestsTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = $this->authAccount();
        $service_requests = ServicesReservations::where('reserved_from_lawyer_id', $lawyer->id)->orderBy('created_at', 'desc')->get();
        $service_requests = ServicesReservationsResource::collection($service_requests);
        return $this->sendResponse(true, ' طلبات التي طلبها العملاء ', compact('service_requests'), 200);
    }
}
