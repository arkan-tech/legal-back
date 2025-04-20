<?php

namespace App\Http\Tasks\Reservations;

use App\Http\Requests\CreateRequestValidation;
use App\Models\AppointmentsRequests;

class CreateRequestTask
{
    public function run(CreateRequestValidation $request)
    {
        $appointmentRequest = AppointmentsRequests::create($request->all());
        return [
            'status' => true,
            'message' => 'Request created successfully.',
            'data' => $appointmentRequest,
            'code' => 201
        ];
    }
}
