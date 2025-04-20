<?php

namespace App\Http\Controllers\API\Lawyer\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Lawyer\Services\HideServicePriceTask;
use App\Http\Tasks\Lawyer\Services\DeleteServicePriceTask;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Tasks\Lawyer\Services\CreateLawyerServicePricesTask;
use App\Http\Tasks\Lawyer\Services\LawyerRateServicesRequestsTask;
use App\Http\Tasks\Lawyer\Services\LawyerReplyServicesRequestsTask;
use App\Http\Tasks\Lawyer\Services\LawyerCreateServicesRequestsTask;
use App\Http\Tasks\Lawyer\Services\LawyerGetServicesRequestsListTask;
use App\Http\Tasks\Lawyer\Services\LawyerReplyClientServicesRequestsTask;
use App\Http\Tasks\Lawyer\Services\LawyerReplyLawyerServicesRequestsTask;
use App\Http\Requests\API\Lawyer\Services\LawyerRateServicesRequestsRequest;
use App\Http\Requests\API\Lawyer\Services\LawyerReplyServicesRequestsRequest;
use App\Http\Tasks\Lawyer\Services\LawyerGetServicesAvailableForCreationTask;
use App\Http\Tasks\Lawyer\Services\RequestedFromLawyer\ListRequestedByIdTask;
use App\Http\Requests\API\Lawyer\Services\LawyerCreateServicesRequestsRequest;
use App\Http\Tasks\Lawyer\Services\RequestedFromLawyer\LawyerListRequestedFromLawyerServicesRequestsTask;
use App\Http\Tasks\Lawyer\Services\RequestedFromLawyer\LawyerListLawyerRequestedFromLawyerServicesRequestsTask;

class LawyerServicesRequestsController extends BaseController
{
    public function create(LawyerCreateServicesRequestsRequest $request, LawyerCreateServicesRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function list(Request $request, LawyerGetServicesRequestsListTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getServices(Request $request, LawyerGetServicesAvailableForCreationTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function listRequestedFromLawyerServicesRequests(Request $request, LawyerListRequestedFromLawyerServicesRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function listLawyerRequestedFromLawyerServicesRequests(Request $request, LawyerListLawyerRequestedFromLawyerServicesRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function listRequestedById(Request $request, ListRequestedByIdTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function listLawyerRequestedFromLawyerServicesRequestsById(Request $request, LawyerListLawyerRequestedFromLawyerServicesRequestsTask $task, $id)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CreateLawyerServicePrices(Request $request, CreateLawyerServicePricesTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function rate(LawyerRateServicesRequestsRequest $request, LawyerRateServicesRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function replyLawyer(LawyerReplyServicesRequestsRequest $request, LawyerReplyLawyerServicesRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function replyClient(LawyerReplyServicesRequestsRequest $request, LawyerReplyClientServicesRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function replya(LawyerReplyServicesRequestsRequest $request, LawyerReplyServicesRequestsTask $task)
    {
        $response = $task->run($request, );
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CompletePaymentLawyerServicesRequests(Request $request, $id)
    {
        $LawyerAdvisoryServicesRequests = LawyerServicesRequest::findOrFail($id);
        $LawyerAdvisoryServicesRequests->update([
            'transaction_complete' => 1
        ]);
        return view('site.api.completePayment');
    }
    public function CancelPaymentLawyerServicesRequests(Request $request, $id)
    {
        $LawyerAdvisoryServicesRequests = LawyerServicesRequest::findOrFail($id);
        $LawyerAdvisoryServicesRequests->update([
            'transaction_complete' => 2
        ]);
        return view('site.api.cancelPaymentLawyer');
    }
    public function DeclinedPaymentLawyerServicesRequests(Request $request, $id)
    {
        $LawyerAdvisoryServicesRequests = LawyerServicesRequest::findOrFail($id);
        $LawyerAdvisoryServicesRequests->update([
            'transaction_complete' => 3
        ]);
        return view('site.api.declinedPaymentLawyer');
    }

    public function deleteServicePrice(Request $request, DeleteServicePriceTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function changeServicePriceTask(Request $request, HideServicePriceTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

}
