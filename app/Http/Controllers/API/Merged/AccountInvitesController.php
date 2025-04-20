<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\Invites\GetInvitesTask;
use App\Http\Tasks\Merged\Invites\CreateInviteTask;
use App\Http\Requests\API\Merged\CreateInviteRequest;
use App\Http\Tasks\Merged\FCM\AccountCreateDeviceTask;
use App\Http\Tasks\Merged\FCM\AccountDeleteDeviceTask;
use App\Http\Requests\API\Client\Device\ClientCreateDeviceRequest;
use App\Http\Requests\API\Client\Device\ClientDeleteDeviceRequest;

class AccountInvitesController extends BaseController
{
    public function getInvites(Request $request, GetInvitesTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function createInvite(CreateInviteRequest $request, CreateInviteTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
