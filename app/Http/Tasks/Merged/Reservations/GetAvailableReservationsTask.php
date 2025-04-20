<?php

namespace App\Http\Tasks\Merged\Reservations;

use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;

class GetAvailableReservationsTask extends BaseTask
{

    public function run()
    {
        $availableReservations = AvailableReservation::with('availableDateTime')->with('reservationTypeImportance')->get(); // Example query, adjust as needed
        $availableReservations = AvailableReservationResource::collection($availableReservations);
        // Return response using a resource to transform the data if necessary
        return $this->sendResponse(true, 'Available Reservations', compact('availableReservations'), 200);
    }
}
