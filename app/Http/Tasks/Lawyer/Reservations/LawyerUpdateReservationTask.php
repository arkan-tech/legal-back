<?php

namespace App\Http\Tasks\Lawyer\Reservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Client\Reservations\ClientUpdateReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\LawyerUpdateReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Lawyer\Reservations\LawyerReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\LawyerReservations\LawyerReservations;

class LawyerUpdateReservationTask extends BaseTask
{

    public function run(LawyerUpdateReservationRequest $request)
    {
        $lawyer = $this->authLawyer();
        $day = strlen($request->day) == 1 ? '0' . $request->day : $request->day;
        $month = strlen($request->month) == 1 ? '0' . $request->month : $request->month;
        $fullDate = $request->year . '-' . $month . '-' . $day;

        $time_clock = strlen($request->time_clock) == 1 ? '0' . $request->time_clock : $request->time_clock;
        $time_minute = strlen($request->time_minute) == 1 ? '0' . $request->time_minute : $request->time_minute;
        $fullTime = $time_clock . ':' . $time_minute . ':00';

        $reservation = LawyerReservations::where('id', $request->reservation_id)->where('reserved_lawyer_id', $lawyer->id)->first();
        $reservation->update([
            'reserved_lawyer_id' => $lawyer->id,
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
        $reservation = new LawyerReservationsResource($reservation);
        return $this->sendResponse(true, 'تم تحديث موعد خاص يمتاز بنجاح', compact('reservation'), 200);
    }
}
