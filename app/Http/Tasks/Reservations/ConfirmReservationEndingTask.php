<?php

namespace App\Http\Tasks\Reservations;

use App\Http\Tasks\BaseTask;
use App\Models\AppointmentsRequests;

class ConfirmReservationEndingTask extends BaseTask
{
    public function run($request)
    {
        $reservation = AppointmentsRequests::find($request->reservation_id);
        if (!$reservation) {
            return [
                'status' => false,
                'message' => 'Reservation not found.',
                'data' => null,
                'code' => 404
            ];
        }

        $reservation->status = 'ended';
        $reservation->save();

        return [
            'status' => true,
            'message' => 'Reservation ended successfully.',
            'data' => $reservation,
            'code' => 200
        ];
    }
}
