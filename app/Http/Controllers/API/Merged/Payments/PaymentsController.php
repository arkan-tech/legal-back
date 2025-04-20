<?php

namespace App\Http\Controllers\API\Merged\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\Payments\PaymentCallbackTask;
use App\Http\Tasks\Merged\Reservations\GetMyReservationsTask;

class PaymentsController extends BaseController
{
    public function callback(Request $request, PaymentCallbackTask $task)
    {
        $response = $task->run($request);
        return $response;
    }
}