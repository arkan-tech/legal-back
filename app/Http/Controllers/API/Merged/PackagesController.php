<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\Packages\GetPackagesTask;
use App\Http\Tasks\Merged\Packages\GetSubscriptionDetailsTask;
use App\Http\Tasks\Merged\Payments\PaymentCallbackTask;
use App\Http\Tasks\Merged\Packages\SubscribePackageTask;
use App\Http\Controllers\Controller;

class PackagesController extends BaseController
{
    public function getPackages(Request $request, GetPackagesTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function subscribe(Request $request, SubscribePackageTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getSubscriptionDetails(Request $request, GetSubscriptionDetailsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
