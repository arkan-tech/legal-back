<?php

namespace App\Http\Controllers\API\Visitor\Services;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Visitor\Services\VisitorCreateServicesRequestsRequest;
use App\Http\Tasks\Visitor\Services\VisitorCreateServicesRequestsTask;

class VisitorServicesRequestsController extends BaseController
{
    public function create(VisitorCreateServicesRequestsRequest $request, VisitorCreateServicesRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }


}
