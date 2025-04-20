<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\FCM\AccountCreateDeviceTask;
use App\Http\Tasks\Merged\FCM\AccountDeleteDeviceTask;
use App\Http\Requests\API\Client\Device\ClientCreateDeviceRequest;
use App\Http\Requests\API\Client\Device\ClientDeleteDeviceRequest;

class AccountFCMController extends BaseController
{
    //
    public function createDevice(ClientCreateDeviceRequest $request, AccountCreateDeviceTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function deleteDevice(ClientDeleteDeviceRequest $request, AccountDeleteDeviceTask $task, $device_id)
    {
        $response = $task->run($request, $device_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
}
