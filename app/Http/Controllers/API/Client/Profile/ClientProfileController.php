<?php

namespace App\Http\Controllers\API\Client\Profile;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Client\Profile\ClientDeleteAccountRequestRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateProfileImageRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Tasks\Client\Profile\ClientDeleteAccountRequestTask;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateProfileImageTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use Illuminate\Http\Request;

class ClientProfileController extends BaseController
{
    public function Profile(Request $request, ClientGetUserProfileTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function Update(ClientUpdateUserProfileRequest $request, ClientUpdateUserProfileTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function UpdateProfileImage(ClientUpdateProfileImageRequest $request, ClientUpdateProfileImageTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function UpdatePassword(ClientUpdateUserPasswordRequest $request, ClientUpdateUserPasswordTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function DeleteAccountRequest(ClientDeleteAccountRequestRequest $request, ClientDeleteAccountRequestTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
}
