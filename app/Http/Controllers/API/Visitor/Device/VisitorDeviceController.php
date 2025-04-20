<?php

namespace App\Http\Controllers\API\Visitor\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\Services\ClientGetServicesTask;
use App\Http\Tasks\Visitor\Profile\GetVisitorProfileTask;
use App\Http\Tasks\Visitor\Device\VisitorCreateDeviceTask;
use App\Http\Tasks\Visitor\Device\VisitorDeleteDeviceTask;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Requests\API\Visitor\Device\VisitorCreateDeviceRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;

class VisitorDeviceController extends BaseController
{
    public function createDevice(VisitorCreateDeviceRequest $request, VisitorCreateDeviceTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function DeleteDevice(Request $request, VisitorDeleteDeviceTask $task, $device_id)
    {
        $response = $task->run($request, $device_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
