<?php

namespace App\Http\Tasks\Reservations;

use App\Http\Tasks\BaseTask;
use App\Models\AppointmentsRequests;

class GetMyRequestedRequestsTask extends BaseTask
{
    public function run($request)
    {
        $client = $this->authClient();
        $requests = AppointmentsRequests::where('account_id', $client->id)->get();
        return [
            'status' => true,
            'message' => 'Requested requests fetched successfully.',
            'data' => $requests,
            'code' => 200
        ];
    }
}
