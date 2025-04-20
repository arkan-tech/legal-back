<?php

namespace App\Http\Controllers\API\Client\Device;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Client\Device\ClientCreateDeviceRequest;
use App\Http\Requests\API\Client\Device\ClientDeleteDeviceRequest;
use App\Http\Tasks\Client\Device\ClientCreateDeviceTask;
use App\Http\Tasks\Client\Device\ClientDeleteDeviceTask;
use App\Http\Tasks\Client\Settings\ClientgetYmtazDatesTask;
use Illuminate\Http\Request;

class ClientDeviceController extends BaseController
{

    public function CreateDevice(ClientCreateDeviceRequest $request , ClientCreateDeviceTask $task){
        $response = $task->run($request);
        return $this->sendResponse($response['status'] , $response['message'] , $response['data'] , $response['code']);

    }
    public function DeleteDevice(ClientDeleteDeviceRequest $request , ClientDeleteDeviceTask $task ,$device_id){
        $response = $task->run($request,$device_id);
        return $this->sendResponse($response['status'] , $response['message'] , $response['data'] , $response['code']);
    }
}
