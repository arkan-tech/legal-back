<?php

namespace App\Http\Tasks\Client\Reservations\YmtazReservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Client\Reservations\YmtazReservations\ClientCreateYmtazReservationRequest;
use App\Http\Requests\API\Client\Reservations\YmtazReservations\ClientUpdateYmtazReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Client\Reservations\YmtazReservations\ClientYmtazReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\Service\Service;
use App\Models\YmtazReservations\YmtazReservations;
use App\Models\YmtazSettings\YmtazWorkDayTimes;
use Exception;

class ClientUpdateYmtazReservationTask extends BaseTask
{

    public function run(ClientUpdateYmtazReservationRequest $request)
    {
        $client = $this->authClient();
        $reservation = YmtazReservations::where('transaction_complete', 1)->where('client_id', $client->id)->where('id', $request->reservation_id)->first();
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
