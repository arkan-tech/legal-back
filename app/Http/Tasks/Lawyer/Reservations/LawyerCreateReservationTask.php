<?php

namespace App\Http\Tasks\Lawyer\Reservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\LawyerCreateReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Lawyer\Reservations\LawyerReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\LawyerReservations\LawyerReservations;

class LawyerCreateReservationTask extends BaseTask
{

    public function run(LawyerCreateReservationRequest $request)
    {
        $lawyer = $this->authLawyer();
        $day = strlen($request->day) == 1 ? '0' . $request->day : $request->day;
        $month = strlen($request->month) == 1 ? '0' . $request->month : $request->month;
        $fullDate = $request->year . '-' . $month . '-' . $day;

        $time_clock = strlen($request->time_clock) == 1 ? '0' . $request->time_clock : $request->time_clock;
        $time_minute = strlen($request->time_minute) == 1 ? '0' . $request->time_minute : $request->time_minute;
        $fullTime = $time_clock . ':' . $time_minute . ': 00';

        $reservation = LawyerReservations::create([
            'reserved_lawyer_id' => $lawyer->id,
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
        $reservation = new LawyerReservationsResource($reservation);
        return $this->sendResponse(true, 'انشاء موعد خاص يمتاز', compact('reservation'), 200);
    }
}
