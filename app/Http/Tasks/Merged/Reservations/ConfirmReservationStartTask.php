<?php

namespace App\Http\Tasks\Merged\Reservations;

use App\Models\Reservations\Reservation;
use Carbon\Carbon;

class ConfirmReservationStartTask
{
    public function run($request, $reservation_id)
    {
        $reservation = Reservation::find($reservation_id);

        if (!$reservation) {
            return [
                'status' => false,
                'message' => 'Reservation not found.',
                'data' => null,
                'code' => 404
            ];
        }
        if ($reservation->reservation_started) {
            return [
                'status' => false,
                'message' => 'Reservation already started.',
                'data' => null,
                'code' => 400
            ];
        }

        if ($reservation->reservation_code !== $request->reservation_code) {
            return [
                'status' => false,
                'message' => 'Invalid reservation code.',
                'data' => null,
                'code' => 400
            ];
        }

        $reservation->update([
            'request_status' => 3,
            'reservation_started' => true,
            'reservation_started_time' => Carbon::now()
        ]);

        return [
            'status' => true,
            'message' => 'Reservation started successfully.',
            'data' => null,
            'code' => 200
        ];
    }
}
