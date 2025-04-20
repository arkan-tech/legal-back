<?php

namespace App\Http\Tasks\Client\Reservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;

class ClientCreateReservationTask extends BaseTask
{

    public function run(ClientCreateReservationRequest $request)
    {
        $client = $this->authClient();
        $day = strlen($request->day) == 1 ? '0' . $request->day : $request->day;
        $month = strlen($request->month) == 1 ? '0' . $request->month : $request->month;
        $fullDate = $request->year . '-' . $month . '-' . $day;

        $time_clock = strlen($request->time_clock) == 1 ? '0' . $request->time_clock : $request->time_clock;
        $time_minute = strlen($request->time_minute) == 1 ? '0' . $request->time_minute : $request->time_minute;
        $fullTime = $time_clock . ':' . $time_minute . ': 00';

        $reservation = ClientReservations::create([
            'client_id' => $client->id,
            'reservation_with_ymtaz' => 0,
            'day' => $request->day,
            'month' => $request->month,
            'year' => $request->year,
            'date' => $fullDate,
            'time_clock' => $request->time_clock,
            'time_minute' => $request->time_minute,
            'fullTime' => $fullTime,
            'type' => $request->type,
            'importance' => $request->importance,
            'notes' => $request->notes,
            'reservation_status' => 1,
        ]);
        $reservation = new ClientReservationsResource($reservation);
        return $this->sendResponse(true, 'انشاء موعد خاص يمتاز', compact('reservation'), 200);
    }
}
