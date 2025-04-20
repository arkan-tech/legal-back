<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Tasks\Admin\CheckIfAdminTask;

class AdminCheckController extends BaseController
{
    public function checkIfAdmin(Request $request, CheckIfAdminTask $task)
    {
        $response = $task->run($request->user());
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
