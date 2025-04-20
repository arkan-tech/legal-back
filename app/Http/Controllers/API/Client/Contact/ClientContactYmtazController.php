<?php

namespace App\Http\Controllers\API\Client\Contact;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Client\ContactYmtaz\SaveContactMessageRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Tasks\Client\ContactYmtaz\ClientGetContactYmtazTask;
use App\Http\Tasks\Client\ContactYmtaz\ClientSaveContactMessageTask;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use Illuminate\Http\Request;

class ClientContactYmtazController extends BaseController
{
    public function List(Request $request, ClientGetContactYmtazTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function Store(SaveContactMessageRequest $request, ClientSaveContactMessageTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

}
