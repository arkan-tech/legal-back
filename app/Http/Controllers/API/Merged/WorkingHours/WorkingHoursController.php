<?php

namespace App\Http\Controllers\API\Merged\WorkingHours;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\WorkingHours\FetchAvailableHours;

class WorkingHoursController extends BaseController
{
    public function fetchAvailableHours(Request $request, FetchAvailableHours $task, $id)
    {
        $response = $task->run($request, $id);
        return $response;
    }
}
