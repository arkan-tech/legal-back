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

class GetNotificationsTask extends BaseTask
{

    public function run()
    {
        \Log::info('test');
        $user = auth()->user();

        $notifications = Notification::where('account_id', $user->id)->orderBy("created_at", "desc")->get();
        return $this->sendResponse(true, 'Notifications', compact('notifications'), 200);
    }
}
