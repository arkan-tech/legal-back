<?php

namespace App\Http\Tasks\Reservations;

use App\Http\Tasks\BaseTask;
use App\Models\AppointmentsRequests;

class GetRequestedReservationsFromMeTask extends BaseTask
{
    public function run($request)
    {
        $user = $this->authAccount();
        $reservations = AppointmentsRequests::where('reserved_from_lawyer', $user->id)->get();
        return [
            'status' => true,
            'message' => 'Requested reservations fetched successfully.',
            'data' => $reservations,
            'code' => 200
        ];
    }
}
