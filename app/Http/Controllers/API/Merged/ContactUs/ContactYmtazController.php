<?php

namespace App\Http\Controllers\API\Merged\ContactUs;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Merged\CreateContactUsRequest;
use App\Http\Tasks\Merged\ContactUs\CreateContactRequest;
use App\Http\Tasks\Merged\ContactUs\GetContactsTypesTask;
use App\Http\Tasks\Merged\ContactUs\GetContactUsRequestsTask;
use App\Http\Tasks\Merged\ContactUs\GetContactUsRequestByIdTask;

class ContactYmtazController extends BaseController
{
    public function create(CreateContactUsRequest $request, CreateContactRequest $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getTypes(Request $request, GetContactsTypesTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getRequests(Request $request, GetContactUsRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getRequestById(Request $request, GetContactUsRequestByIdTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
