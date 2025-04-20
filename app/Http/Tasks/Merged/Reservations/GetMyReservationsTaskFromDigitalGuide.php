<?php

namespace App\Http\Tasks\Merged\Reservations;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\API\Splash\Splash;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservations\Reservation;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\API\Reservations\ReservationResource;
use App\Http\Resources\API\Reservations\TempReservationResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;

class GetMyReservationsTaskFromDigitalGuide extends BaseTask
{

    public function run(Request $request)
    {
        $user = $this->authAccount();
        $reservations = Reservation::with([
            'reservationTypeImportance' => function ($query) {
                $query->with(['reservationType', 'reservationImportance']);
            }
        ])->where('account_id', $user->id)->whereNotNull('reserved_from_lawyer_id')->where('transaction_complete', 1)->get();


        $reservations = ReservationResource::collection($reservations);
        // Return response using a resource to transform the data if necessary
        return $this->sendResponse(true, 'Reservations', compact('reservations'), 200);
    }
}
