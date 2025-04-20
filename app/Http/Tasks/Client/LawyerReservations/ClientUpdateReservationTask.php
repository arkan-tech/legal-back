<?php

namespace App\Http\Tasks\Client\Reservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Client\Reservations\ClientUpdateReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;

class ClientUpdateReservationTask extends BaseTask
{

    public function run(ClientUpdateReservationRequest $request)
    {
        $client = $this->authClient();
        $day = strlen($request->day) == 1 ? '0' . $request->day : $request->day;
        $month = strlen($request->month) == 1 ? '0' . $request->month : $request->month;
        $fullDate = $request->year . '-' . $month . '-' . $day;

        $time_clock = strlen($request->time_clock) == 1 ? '0' . $request->time_clock : $request->time_clock;
        $time_minute = strlen($request->time_minute) == 1 ? '0' . $request->time_minute : $request->time_minute;
        $fullTime = $time_clock . ':' . $time_minute . ':00';

        $reservation = ClientReservations::where('id', $request->reservation_id)->where('client_id', $client->id)->first();
        $reservation->update([
            'client_id' => $client->id,
            'day' => $day,
            'month' => $month,
            'year' => $request->year,
            'date' => $fullDate,
            'time_clock' => $time_clock,
            'time_minute' => $time_minute,
            'fullTime' => $fullTime,
            'type' => $request->type,
            'importance' => $request->importance,
            'notes' => $request->notes,
        ]);
        $reservation = new ClientReservationsResource($reservation);
        return $this->sendResponse(true, 'تم تحديث موعد مفكرة يمتاز بنجاح', compact('reservation'), 200);
    }
}
