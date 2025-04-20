<?php

namespace App\Http\Controllers\API\Lawyer;

use Illuminate\Http\Request;
use App\Models\AccountBankInfo;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\AccountBankInfoResource;
use App\Http\Requests\UpdateAccountBankInfoRequest;
use App\Tasks\AccountBankInfo\ShowAccountBankInfoTask;
use App\Tasks\AccountBankInfo\UpdateAccountBankInfoTask;

class AccountBankInfoController extends BaseController
{
    public function show(Request $request, ShowAccountBankInfoTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function update(UpdateAccountBankInfoRequest $request, UpdateAccountBankInfoTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
