<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\Payments\GetPaymentsTask;
use App\Http\Tasks\Merged\FCM\AccountCreateDeviceTask;
use App\Http\Tasks\Merged\FCM\AccountDeleteDeviceTask;
use App\Http\Requests\API\Client\Device\ClientCreateDeviceRequest;
use App\Http\Requests\API\Client\Device\ClientDeleteDeviceRequest;

class PaymentsController extends BaseController
{

    public function getPayments(Request $request, GetPaymentsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
