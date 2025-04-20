<?php

namespace App\Http\Controllers\API\Lawyer;

use Illuminate\Http\Request;
use App\Models\LawyerPayoutRequests;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Lawyer\LawyerPayouts\GetLawyerWallet;
use App\Http\Tasks\Lawyer\LawyerPayouts\GetLawyerPayouts;
use App\Http\Tasks\Lawyer\LawyerPayouts\CreateLawyerPayout;

class LawyerPayoutsController extends BaseController
{

    public function index(Request $request, GetLawyerPayouts $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function wallet(Request $request, GetLawyerWallet $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }


    public function store(Request $request, CreateLawyerPayout $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

}
