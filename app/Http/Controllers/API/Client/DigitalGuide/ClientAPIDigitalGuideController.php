<?php

namespace App\Http\Controllers\API\Client\DigitalGuide;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\DigitalGuide\getLawyersBaseFilterRequest;
use App\Http\Tasks\Client\DigitalGuide\Categories\getAllDigitalGuideCategoriesTask;
use App\Http\Tasks\Client\DigitalGuide\Filter\getLawyersBaseFilterTask;
use Illuminate\Http\Request;

class ClientAPIDigitalGuideController extends BaseController
{
    public function getCategories(Request $request , getAllDigitalGuideCategoriesTask $task){
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getLawyersBaseFilter(getLawyersBaseFilterRequest $request , getLawyersBaseFilterTask $task){
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
}
