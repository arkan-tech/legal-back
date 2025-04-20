<?php

namespace App\Http\Controllers\API\Client\Settings;

use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\Settings\ClientgetYmtazDatesTask;
use Illuminate\Http\Request;

class ClientYamtazSettingsController extends BaseController
{
    public function getYmtazDates(Request $request, ClientgetYmtazDatesTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }


}
