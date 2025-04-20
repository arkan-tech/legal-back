<?php

namespace App\Http\Tasks\Lawyer\Reservations\YmtazReservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Client\Reservations\YmtazReservations\ClientYmtazReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\YmtazReservations\YmtazLawyerReservations;
use App\Models\YmtazReservations\YmtazReservations;
use Illuminate\Http\Request;

class LawyerCancelYmtazReservationTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $lawyer = $this->authLawyer();
        $reservation = YmtazLawyerReservations::where('id', $id)->where('transaction_complete', 1)->where('lawyer_id', $lawyer->id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, ' الحجز غير موجود', null, 404);
        }
        if ($reservation->status == 2) {
            return $this->sendResponse(false, 'للاسف الحجز غير قابل ل الالغاء الموعد بسبب اكتمال الموعد', null, 402);
        }
        if ($reservation->status == 3) {
            return $this->sendResponse(false, ' الحجز    ملغي بالفعل   ', null, 402);
        }
        $reservation->update([
            'status' => 3
        ]);

        $reservation = new ClientYmtazReservationResource($reservation);
        return $this->sendResponse(true, '   تم الغاء الموعد بنجاح', compact('reservation'), 200);
    }
}
