<?php

namespace App\Http\Tasks\Merged\Reservations;

use App\Http\Resources\API\Reservations\ReservationConnectionTypeResource;
use App\Http\Tasks\BaseTask;
use App\Models\Reservations\ReservationConnectionType;

class GetReservationConnTypesTask extends BaseTask
{

    public function run()
    {
        $reservations_conn_types = ReservationConnectionType::where('isVisible', 1)->get();
        $reservations_conn_types = ReservationConnectionTypeResource::collection($reservations_conn_types);
        return $this->sendResponse(true, 'Reservation Connection types', compact('reservations_conn_types'), 200);
    }
}
