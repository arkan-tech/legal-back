<?php

namespace App\Http\Tasks\Client\Services;

use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Http\Resources\ServicesReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientRequest;
use App\Models\Service\ServicesRequest;
use App\Models\ServicesReservations;
use Illuminate\Http\Request;

class ClientGetServicesRequestsListTask extends BaseTask
{

    public function run(Request $request)
    {
        $client = $this->authAccount();
        $service_requests = ServicesReservations::where('transaction_complete', 1)->where('account_id', operator: $client->id)->orderBy('created_at', 'desc')->get();
        $service_requests = ServicesReservationsResource::collection($service_requests);
        return $this->sendResponse(true, ' طلباتي ', compact('service_requests'), 200);
    }
}
