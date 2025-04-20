<?php

namespace App\Http\Controllers\API\Lawyer\ContactYmtaz;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Lawyer\ContactYmtaz\LawyerSaveContactMessageRequest;
use App\Http\Tasks\Lawyer\ContactYmtaz\LawyerGetContactYmtazTask;
use App\Http\Tasks\Lawyer\ContactYmtaz\LawyerSaveContactMessageTask;
use Illuminate\Http\Request;

class LawyerContactYmtazController extends BaseController
{
    public function list(Request $request, LawyerGetContactYmtazTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function Store(LawyerSaveContactMessageRequest $request, LawyerSaveContactMessageTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

}
