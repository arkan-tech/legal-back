<?php

namespace App\Http\Controllers\API\Lawyer\WorkingHours;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\AddWorkingHoursRequest;
use App\Http\Tasks\Lawyer\WorkingHours\AddWorkingHoursTask;
use App\Http\Tasks\Lawyer\WorkingHours\GetWorkingHoursTask;
use App\Http\Tasks\Lawyer\Settings\LawyerTermsAndConditionsTask;

class WorkingHoursController extends BaseController
{
    public function addWorkingHours(Request $request, AddWorkingHoursTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getWorkingHours(Request $request, GetWorkingHoursTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
