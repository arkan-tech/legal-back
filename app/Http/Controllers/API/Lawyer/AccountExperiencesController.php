<?php

namespace App\Http\Controllers\API\Lawyer;

use App\Http\Requests\StoreAccountExperiencesRequest;
use Illuminate\Http\Request;
use App\Models\AccountExperience;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\AccountExperienceResource;
use App\Tasks\AccountExperiences\StoreAccountExperienceTask;
use App\Tasks\AccountExperiences\IndexAccountExperiencesTask;

class AccountExperiencesController extends BaseController
{
    public function index(Request $request, IndexAccountExperiencesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function store(StoreAccountExperiencesRequest $request, StoreAccountExperienceTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
