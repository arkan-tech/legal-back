<?php

namespace App\Http\Tasks\Client\LawyerReservations;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientLawyerReservationsResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientLawyerReservations;
use App\Models\ClientReservations\ClientReservations;

class ClientGetServicesReservationsLawyerTask extends BaseTask
{

    public function run()
    {
        $client = $this->authClient();
        $reservations = ClientLawyerReservations::where('client_id', $client->id)->where('transaction_complete', 1)->orderBy('created_at', 'desc')->get();
        $reservations = ClientLawyerReservationsResource::collection($reservations);
        return $this->sendResponse(true, ' حجوزات مقدمين الخدمة', compact('reservations'), 200);
    }
}
