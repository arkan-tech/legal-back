<?php

namespace App\Http\Tasks\Lawyer\NewReservations;

use Carbon\Carbon;
use App\Http\Tasks\BaseTask;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Devices\ClientFcmDevice;
use App\Models\Devices\LawyerFcmDevice;
use App\Models\Reservations\Reservation;
use App\Models\Reservations\ReservationType;
use App\Models\Reservations\AvailableReservation;
use App\Models\Reservations\ReservationImportance;
use App\Http\Controllers\PushNotificationController;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Models\ClientReservations\ClientReservations;
use App\Models\LawyerReservations\LawyerReservations;
use App\Models\Reservations\ReservationTypeImportance;
use App\Models\Reservations\AvailableReservationDateTime;
use App\Http\Resources\API\Reservations\ReservationImportanceResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Lawyer\Reservations\LawyerReservationsResource;
use App\Http\Resources\API\Reservations\ReservationTypeImportanceResource;
use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\LawyerCreateReservationRequest;

class LawyerChangeReservationStatus extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = $this->authLawyer();
        $reservation = Reservation::where('reserved_from_lawyer_id', $lawyer->id)->findOrFail($request->id);
        if ($reservation->reservationEnded == 1) {
            return $this->sendResponse(false, "هذا الموعد تم الأنتهاء منه بالفعل", null, 400);
        }
        $reservation->reservationEnded = 1;
        $reservation->reservationEndedTime = Carbon::now()->toDateTimeString();
        $reservation->save();
        $notification = Notification::create([
            'title' => "انتهاء الموعد",
            "description" => "تم الأنتهاء من الموعد",
            "type" => "appointment",
            "type_id" => $reservation->id,
            "userType" => $reservation->reserverType,
            "lawyer_id" => $reservation->reserverType == "lawyer" ? $reservation->lawyer_id : null,
            "service_user_id" => $reservation->reserverType == "client" ? $reservation->service_user_id : null,
        ]);
        if ($reservation->reserverType == "lawyer") {
            $fcms = LawyerFcmDevice::where("lawyer_id", $reservation->lawyer_id)->get()->map(function ($fcm) {
                return $fcm->fcm_token;
            });
        } else {
            $fcms = ClientFcmDevice::where("client_id", $reservation->service_user_id)->get()->map(function ($fcm) {
                return $fcm->fcm_token;
            });
        }

        $notificationController = new PushNotificationController;
        foreach ($fcms as $fcm) {
            $notificationController->sendNotification($fcm, "انتهاء الموعد", "تم الأنتهاء من الموعد", ["type" => "appointment", "type_id" => $reservation->id]);
        }
        return $this->sendResponse(true, "Reservation Ended successfully", null, 200);
    }
}
