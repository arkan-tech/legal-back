<?php

namespace App\Http\Controllers\API\Client\Settings;

use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\Settings\ClientgettermsAndConditionsTask;
use App\Http\Tasks\Client\Settings\ClientgetYmtazDatesTask;
use Illuminate\Http\Request;

class ClientSettingsController extends BaseController
{
    public function gettermsAndConditions(Request $request, ClientgettermsAndConditionsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }


}
