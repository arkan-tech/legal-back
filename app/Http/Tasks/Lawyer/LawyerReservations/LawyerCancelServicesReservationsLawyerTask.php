<?php

namespace App\Http\Tasks\Lawyer\LawyerReservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientLawyerReservationsResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Lawyer\Reservations\LawyerReservationsLawyerResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientLawyerReservations;
use App\Models\ClientReservations\ClientReservations;
use App\Models\Lawyer\LawyerReservationsLawyer;
use Illuminate\Http\Request;

class LawyerCancelServicesReservationsLawyerTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $client = $this->authLawyer();
        $reservation = LawyerReservationsLawyer::where('reserved_lawyer_id', $client->id)->where('id', $id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, ' الحجز غير موجود', null, 404);
        }
        $reservation->update([
            'complete_status' => 2
        ]);

        $reservation = new LawyerReservationsLawyerResource($reservation);
        return $this->sendResponse(true, '   تم الغاء الموعد بنجاح', compact('reservation'), 200);
    }
}
