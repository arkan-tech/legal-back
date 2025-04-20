<?php

namespace App\Http\Tasks\Merged\Lawyer;

use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;

class GetLawyerAvailableReservationsTask extends BaseTask
{

    public function run($id)
    {
        $availableReservations = AvailableReservation::with(
            'reservationTypeImportance'
        )->where('isYmtaz', 0)->where('lawyer_id', $id)->get();
        $availableReservations = AvailableReservationResource::collection($availableReservations);
        return $this->sendResponse(true, 'Available Reservations for lawyer', compact('availableReservations'), 200);
    }
}
