<?php

namespace App\Http\Tasks\Lawyer\Reservations\RequestedFromLawyer;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Reservations\Reservation;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Models\ClientReservations\ClientReservations;
use App\Http\Resources\API\Reservations\ReservationResource;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;

class GetMyReservationByIdTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $lawyer = $this->authLawyer();
        $reservation = Reservation::where('reserved_from_lawyer_id', $lawyer->id)->where('transaction_complete', 1)->findOrFail($id);
        $reservation = ReservationResource::collection($reservation);
        return $this->sendResponse(true, 'الموعد', compact('reservations'), 200);
    }
}
