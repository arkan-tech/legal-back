<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\GetActivitiesTask;
use App\Http\Tasks\Merged\Profile\GetMyPageTask;
use App\Http\Tasks\Merged\Homescreen\GetMostBoughtTask;

class ActivitiesController extends BaseController
{
    public function getActivities(Request $request, GetActivitiesTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
