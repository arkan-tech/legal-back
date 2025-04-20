<?php

namespace App\Http\Tasks\Merged\Reservations;

use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\Reservations\ReservationTypeResource;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Models\Reservations\ReservationType;

class GetReservationTypesTask extends BaseTask
{

    public function run()
    {
        $reservations_types = ReservationType::where('isHidden', 0)->with(
            [
                'typesImportance' => function ($query) {
                    $query->where('isYmtaz', 1)->where('isHidden', 0);
                }
            ]
        )->get();
        $reservations_types = ReservationTypeResource::collection($reservations_types);
        // Return response using a resource to transform the data if necessary
        return $this->sendResponse(true, 'Reservation Types', compact('reservations_types'), 200);
    }
}
