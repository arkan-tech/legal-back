<?php

namespace App\Http\Controllers\API\Merged\Profile;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\GetMostBoughtTask;
use App\Http\Tasks\Merged\Profile\GetMyPageTask;
use App\Http\Tasks\Merged\Profile\GetAnalyticsTask;
use App\Http\Tasks\Merged\Profile\GetMyProfileTask;
use App\Http\Tasks\Merged\Profile\UpdateProfileTask;

class ProfileController extends BaseController
{
    public function getMyPage(Request $request, GetMyPageTask $task)
    {
        $response = $task->run();
        // dd($response['status']);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getAnalytics(Request $request, GetAnalyticsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getProfile(Request $request, GetMyProfileTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function updateProfile(UpdateProfileRequest $request, UpdateProfileTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getMostBought(Request $request, GetMostBoughtTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
}