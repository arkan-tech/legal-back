<?php

namespace App\Http\Tasks\Lawyer\Reservations\YmtazReservations;

use App\Http\Requests\API\Lawyer\Reservations\YmtazReservations\LawyerUpdateYmtazReservationRequest;
use App\Http\Resources\API\Client\Reservations\YmtazReservations\ClientYmtazReservationResource;
use App\Http\Tasks\BaseTask;

use App\Models\YmtazReservations\YmtazLawyerReservations;
use App\Models\YmtazSettings\YmtazWorkDayTimes;
use Exception;

class LawyerUpdateYmtazReservationTask extends BaseTask
{

    public function run(LawyerUpdateYmtazReservationRequest $request)
    {
        $lawyer = $this->authLawyer();
        $reservation = YmtazLawyerReservations::where('transaction_complete', 1)->where('lawyer_id', $lawyer->id)->where('id', $request->reservation_id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, 'للاسف الحجز غير موجود', null, 404);
        }
        if ($reservation->status == 2) {
            return $this->sendResponse(false, 'للاسف الحجز غير قابل ل تغيير الموعد بسبب اكتمال الموعد', null, 404);

        }

        $date_times = YmtazWorkDayTimes::where('ymtaz_available_dates_id', $request->ymtaz_date_id)->where('id', $request->ymtaz_date_id)->get();
        if (is_null($date_times)) {
            return $this->sendResponse(false, 'للاسف   التوقيت غير متاح', null, 404);

        }
        $reservation ->update([
            'ymtaz_date_id' => $request->ymtaz_date_id,
            'ymtaz_time_id' => $request->ymtaz_time_id,

        ]);


        $reservation = new ClientYmtazReservationResource($reservation);
        return $this->sendResponse(true, 'تم تحديث الموعد بنجاح', compact('reservation'), 200);
    }
}
