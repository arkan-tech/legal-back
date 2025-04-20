<?php

namespace App\Http\Controllers\API\Client\Services;

use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\RequestLevels\ClientGetRequestLevelsTask;
use App\Http\Tasks\Client\Services\ClientGetMainCategoriesServicesTask;
use App\Http\Tasks\Client\Services\ClientGetServices14Task;
use App\Http\Tasks\Client\Services\ClientGetServicesTask;
use App\Http\Tasks\Client\Services\ClientGetSubCategoriesServicesTask;
use Illuminate\Http\Request;

class ServicesController extends BaseController
{
    public function List(Request $request, ClientGetServicesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function List14(Request $request, ClientGetServices14Task $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function MainCategories(Request $request, ClientGetMainCategoriesServicesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function SubCategories(Request $request, ClientGetSubCategoriesServicesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function RequestLevels(Request $request, ClientGetRequestLevelsTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }


}
