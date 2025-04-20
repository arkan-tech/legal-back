<?php

namespace App\Http\Controllers\API\Visitor\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\Services\ClientGetServicesTask;
use App\Http\Tasks\Visitor\Profile\GetVisitorProfileTask;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;

class VisitorProfileController extends BaseController
{
    public function getProfile(Request $request, GetVisitorProfileTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

}
