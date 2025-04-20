<?php

namespace App\Http\Tasks\Client\Reservations\YmtazReservations;

use App\Http\Requests\API\Client\AdvisoryService\ClientCreateAdvisoryServiceReservationRequest;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Resources\API\Client\Reservations\YmtazReservations\ClientYmtazReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\YmtazReservations\YmtazReservations;

class ClientGetYmtazReservationTask extends BaseTask
{

    public function run()
    {
        $client = $this->authClient();

        $reservations = YmtazReservations::where('transaction_complete', 1)->where('client_id', $client->id)->orderBy('created_at', 'desc')->get();

        $reservations = ClientYmtazReservationResource::collection($reservations);
        return $this->sendResponse(true, ' قائمة  الحجوزات مع يمتاز', compact('reservations'), 200);
    }
}
