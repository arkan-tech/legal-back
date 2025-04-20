<?php

namespace App\Http\Tasks\Client\Reservations\Requirements;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationTypeResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\ClientReservations\ClientReservationsTypes;

class ClientGetReservationTypeTask extends BaseTask
{

    public function run()
    {
        $items = ClientReservationsTypes::where('status', 1)->orderBy('created_at','desc')->get();
        $items = ClientReservationTypeResource::collection($items);
        return $this->sendResponse(true, ' انواع الجلسات', compact('items'), 200);
    }
}
