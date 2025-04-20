<?php

namespace App\Http\Tasks\Client\Reservations\Requirements;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\ClientReservations\ClientReservationsImportance;

class ClientGetImportanceTypeTask extends BaseTask
{

    public function run()
    {
        $items = ClientReservationsImportance::where('status', 1)->orderBy('created_at','desc')->get();
        $items = ClientReservationsImportanceResource::collection($items);
        return $this->sendResponse(true, 'حالات الاهمية', compact('items'), 200);
    }
}
