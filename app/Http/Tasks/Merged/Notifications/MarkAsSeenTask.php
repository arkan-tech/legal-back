<?php

namespace App\Http\Tasks\Merged\Notifications;

use App\Http\Tasks\BaseTask;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\API\Splash\Splash;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservations\Reservation;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\API\Reservations\ReservationResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;

class MarkAsSeenTask extends BaseTask
{

    public function run(Request $request)
    {
        $user = auth()->user();
        $notification = Notification::where("account_id", $user->id)->findOrFail($request->id);
        if ($notification->seen == 1) {
            return $this->sendResponse(false, "Notification already seen", null, 400);
        }
        $notification->seen = 1;
        $notification->save();
        return $this->sendResponse(true, 'Notification marked as seen', null, 200);
    }
}
