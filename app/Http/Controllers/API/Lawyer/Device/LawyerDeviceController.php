<?php

namespace App\Http\Controllers\API\Lawyer\Device;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Lawyer\Device\LawyerCreateDeviceRequest;
use App\Http\Requests\API\Lawyer\Device\LawyerDeleteDeviceRequest;
use App\Http\Tasks\Lawyer\Device\LawyerCreateDeviceTask;
use App\Http\Tasks\Lawyer\Device\LawyerDeleteDeviceTask;
use Illuminate\Http\Request;

class LawyerDeviceController extends BaseController
{

    public function CreateDevice(LawyerCreateDeviceRequest $request , LawyerCreateDeviceTask $task){
        $response = $task->run($request);
        return $this->sendResponse($response['status'] , $response['message'] , $response['data'] , $response['code']);

    }
    public function DeleteDevice(LawyerDeleteDeviceRequest $request , LawyerDeleteDeviceTask $task ,$device_id){
        $response = $task->run($request,$device_id);
        return $this->sendResponse($response['status'] , $response['message'] , $response['data'] , $response['code']);
    }
}
