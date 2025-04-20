<?php

namespace App\Http\Tasks\Lawyer\NewReservations;

use App\Http\Resources\API\Reservations\ReservationImportanceResource;
use App\Http\Tasks\BaseTask;
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

class LawyerGetReservationImportanceTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = $this->authLawyer();
        $reservationImportance = ReservationImportance::get();
        $reservationImportance = ReservationImportanceResource::collection($reservationImportance);
        return $this->sendResponse(true, "Reservations importance", compact('reservationImportance'), 200);
    }
}
