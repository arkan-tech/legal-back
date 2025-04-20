<?php

namespace App\Http\Controllers\API\Lawyer\DigitalGuidePackages;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Lawyer\DigitalGuidePackages\CancelPaymentPackageTask;
use App\Http\Tasks\Lawyer\DigitalGuidePackages\CompletePaymentPackageTask;
use App\Http\Tasks\Lawyer\DigitalGuidePackages\DeclinedPaymentPackageTask;
use App\Http\Tasks\Lawyer\DigitalGuidePackages\LawyerGetDigitalGuidePricesTask;
use App\Http\Tasks\Lawyer\DigitalGuidePackages\SubscribeToDigitalGuidePackageTask;

class DigitalGuidePackagesController extends BaseController
{

    // public function CreateAdvisoryServices(LawyerCreateAdvisoryServiceReservationRequest $request, LawyerCreateAdvisoryServiceReservationTask $task)
    // {
    //     $response = $task->run($request);
    //     return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    // }
    public function GetDigitalGuidePackages(Request $request, LawyerGetDigitalGuidePricesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function SubscribeToDigitalGuidePackage(Request $request, SubscribeToDigitalGuidePackageTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CompletePaymentPackage(Request $request, CompletePaymentPackageTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $response;
    }

    public function CancelPaymentPackage(Request $request, CancelPaymentPackageTask $task, $id)
    {
        $response = $task->run($request);
        return $response;

    }

    public function DeclinedPaymentPackage(Request $request, DeclinedPaymentPackageTask $task, $id)
    {
        $response = $task->run($request);
        return $response;

    }
}
