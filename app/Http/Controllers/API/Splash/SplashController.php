<?php

namespace App\Http\Controllers\API\Splash;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Tasks\Benefit\getBenefitListTask;
use App\Http\Tasks\Benefit\getVersionTask;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use App\Http\Tasks\Splash\getSplashListTask;
use Illuminate\Http\Request;

class SplashController extends BaseController
{
    public function getSplashList(Request $request, getSplashListTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getBenefitList(Request $request, getBenefitListTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getVersion(Request $request, getVersionTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
}
