<?php

namespace App\Http\Tasks\Lawyer\Reservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\LawyerReservations\LawyerReservations;
use Illuminate\Http\Request;

class LawyerCancelReservationTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $lawyer = $this->authLawyer();
        $reservation = LawyerReservations::where('reserved_lawyer_id', $lawyer->id)->where('id', $id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, ' الحجز غير موجود', null, 404);
        }
        $reservation->update([
            'reservation_status' => 4
        ]);

        $reservation = new ClientReservationsResource($reservation);
        return $this->sendResponse(true, '   تم الغاء الموعد بنجاح', compact('reservation'), 200);
    }
}
