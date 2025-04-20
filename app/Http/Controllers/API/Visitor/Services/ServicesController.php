<?php

namespace App\Http\Controllers\API\Client\Services;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use App\Http\Tasks\Client\Services\ClientGetServicesTask;
use Illuminate\Http\Request;

class ServicesController extends BaseController
{
    public function List(Request $request, ClientGetServicesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

}
