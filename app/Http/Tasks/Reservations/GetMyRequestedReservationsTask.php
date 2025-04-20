<?php

namespace App\Http\Tasks\Reservations;

use App\Http\Tasks\BaseTask;
use App\Models\AppointmentsRequests;

class GetMyRequestedReservationsTask extends BaseTask
{
    public function run($request)
    {
        $client = $this->authClient();
        $reservations = AppointmentsRequests::where('account_id', $client->id)->get();
        return [
            'status' => true,
            'message' => 'Requested reservations fetched successfully.',
            'data' => $reservations,
            'code' => 200
        ];
    }
}
