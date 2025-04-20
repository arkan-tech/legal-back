<?php

namespace App\Http\Tasks\Lawyer\NewReservations;

use App\Http\Resources\API\Reservations\ReservationImportanceResource;
use App\Http\Resources\API\Reservations\ReservationTypeImportanceResource;
use App\Http\Tasks\BaseTask;
use App\Models\Reservations\AvailableReservationDateTime;
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

class LawyerGetReservationTypeImportanceTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = $this->authLawyer();
        $reservationTypesImportances = ReservationTypeImportance::with(['reservationType', "reservationImportance"])->where('lawyer_id', $lawyer->id)->get();
        $reservationTypesImportances = ReservationTypeImportanceResource::collection($reservationTypesImportances);
        return $this->sendResponse(true, "Reservations Types importance", compact('reservationTypesImportances'), 200);
    }
}
