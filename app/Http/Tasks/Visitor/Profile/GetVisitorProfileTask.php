<?php

namespace App\Http\Tasks\Visitor\Profile;

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

class GetVisitorProfileTask extends BaseTask
{

    public function run()
    {
        $user = auth()->guard('api_visitor')->user();
        if ($user->status == 0) {
            return $this->sendResponse(false, 'Unauthorized', "هذا الحساب موقوف", 403);
        }
        return $this->sendResponse(true, 'Visitor Profile', compact('user'), 200);
    }
}
