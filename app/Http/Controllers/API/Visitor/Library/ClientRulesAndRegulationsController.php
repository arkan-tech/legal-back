<?php

namespace App\Http\Controllers\API\Visitor\Library;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Visitor\Library\getAllRulesAndRegulationsBaseFilterRequest;
use App\Http\Tasks\Visitor\Library\RulesAndRegulations\ClientGetAllRulesAndRegulationsBaseFilterTask;
use App\Http\Tasks\Visitor\Library\RulesAndRegulations\ClientGetAllRulesAndRegulationsTask;
use App\Http\Tasks\Visitor\Library\RulesAndRegulations\ClientGetRulesAndRegulationsBaseIdTask;
use App\Http\Tasks\Visitor\Library\RulesAndRegulations\ClientGetRulesAndRegulationsDataTask;
use Illuminate\Http\Request;

class ClientRulesAndRegulationsController extends BaseController
{

    public function getAllRulesAndRegulations(Request $request, ClientGetAllRulesAndRegulationsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getRulesAndRegulationsData (Request $request, ClientGetRulesAndRegulationsDataTask $task,$id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }


    public function getRulesAndRegulationsBaseSubCategoryId(Request $request, ClientGetRulesAndRegulationsBaseIdTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getAllRulesAndRegulationsBaseFilter(getAllRulesAndRegulationsBaseFilterRequest $request, ClientGetAllRulesAndRegulationsBaseFilterTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
}
