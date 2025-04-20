<?php

namespace App\Http\Tasks\Lawyer\NewReservations;

use App\Http\Resources\API\Reservations\ReservationImportanceResource;
use App\Http\Resources\API\Reservations\ReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\Reservations\Reservation;
use Illuminate\Http\Request;
use App\Models\Reservations\ReservationType;
use App\Models\Reservations\AvailableReservation;
use App\Models\Reservations\ReservationImportance;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Models\ClientReservations\ClientReservations;
use App\Models\LawyerReservations\LawyerReservations;
use App\Models\Reservations\ReservationTypeImportance;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Lawyer\Reservations\LawyerReservationsResource;
use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\LawyerCreateReservationRequest;

class LawyerGetMyReservationsTaskClient extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = $this->authAccount();
        $reservations = Reservation::where('reserved_from_lawyer_id', $lawyer->id)
            // ->where('transaction_complete', 1)
            ->get();
        $reservations = ReservationResource::collection($reservations);
        return $this->sendResponse(true, "My Reservations", compact('reservations'), 200);
    }
}
