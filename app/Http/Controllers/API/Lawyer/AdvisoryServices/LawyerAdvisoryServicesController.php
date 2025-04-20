<?php

namespace App\Http\Controllers\API\Lawyer\AdvisoryServices;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\ListRequestedByIdTask;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\HideAdvisoryServicePriceTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\DeleteAdvisoryServicePriceTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\GetAvailableServicesForPricingTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\CreateLawyerAdvisoryServicePricesTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\LawyerListAdvisoryServiceReservationTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\LawyerRateAdvisoryServiceReservationTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\LawyerDelayAdvisoryServiceReservationTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\LawyerCreateAdvisoryServiceReservationTask;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\LawyerRateAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\LawyerDelayAdvisoryServiceReservationRequest;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\RequestedFromLawyer\LawyerReplyAdvisoryServiceTask;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\LawyerCreateAdvisoryServiceReservationRequest;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\LawyerListAdvisoryServiceReservationFromLawyersTask;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\Lawyer\LawyerReplyClientAdvisoryServiceRequest;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\LawyerDelayAppointmentAdvisoryServiceReservationTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\LawyerCancelAppointmentAdvisoryServiceReservationTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\RequestedFromLawyer\LawyerReplyClientAdvisoryServiceTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\RequestedFromLawyer\LawyerReplyLawyerAdvisoryServiceTask;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\LawyerDelayAppointmentAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\LawyerCancelAppointmentAdvisoryServiceReservationRequest;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\RequestedFromLawyer\LawyerListAdvisoryServiceReservationFromLawyerTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\RequestedFromLawyer\LawyerListAdvisoryServiceReservationFromLawyerTaskClient;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\RequestedFromLawyer\LawyerListAdvisoryServiceReservationFromLawyerTaskLawyer;

class LawyerAdvisoryServicesController extends BaseController
{

    public function CreateAdvisoryServices(LawyerCreateAdvisoryServiceReservationRequest $request, LawyerCreateAdvisoryServiceReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function AppointmentAdvisoryServices(LawyerDelayAdvisoryServiceReservationRequest $request, LawyerDelayAdvisoryServiceReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function listRequestedById(Request $request, ListRequestedByIdTask $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function ListLawyerAdvisoryServicesRequests(Request $request, LawyerListAdvisoryServiceReservationTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function ListLawyerAdvisoryServicesRequestsFromLawyers(Request $request, LawyerListAdvisoryServiceReservationFromLawyersTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function DelayLawyerAdvisoryServicesRequests(LawyerDelayAppointmentAdvisoryServiceReservationRequest $request, LawyerDelayAppointmentAdvisoryServiceReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function CancelLawyerAdvisoryServicesRequests(LawyerCancelAppointmentAdvisoryServiceReservationRequest $request, LawyerCancelAppointmentAdvisoryServiceReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function RateAdvisoryServicesReservation(LawyerRateAdvisoryServiceReservationRequest $request, LawyerRateAdvisoryServiceReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    function GetAvailableServicesForPricing(Request $request, GetAvailableServicesForPricingTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    /// requested from Lawyer ///
    public function ListClientAdvisoryServicesReservations(Request $request, LawyerListAdvisoryServiceReservationFromLawyerTaskClient $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function ListLawyerAdvisoryServicesReservations(Request $request, LawyerListAdvisoryServiceReservationFromLawyerTaskLawyer $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function ReplyAdvisoryServiceClient(LawyerReplyClientAdvisoryServiceRequest $request, LawyerReplyClientAdvisoryServiceTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function ReplyAdvisoryServiceLawyer(Request $request, LawyerReplyLawyerAdvisoryServiceTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    ///
    public function CreateLawyerAdvisoryServicePrices(Request $request, CreateLawyerAdvisoryServicePricesTask $task)
    {

        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function deleteAdivsoryServicePrice(Request $request, DeleteAdvisoryServicePriceTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function changeAdvisoryServicePriceTask(Request $request, HideAdvisoryServicePriceTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CompletePaymentClientAdvisoryServicesRequests(Request $request, $id)
    {
        $ClientAdvisoryServicesReservations = LawyerAdvisoryServicesReservations::findOrFail($id);
        $ClientAdvisoryServicesReservations->update([
            'transaction_complete' => 1,
            'accept_date' => date('Y-m-d'),
        ]);
        return view('site.api.completePayment');
    }

    public function CancelPaymentClientAdvisoryServicesRequests(Request $request, $id)
    {
        $ClientAdvisoryServicesReservations = LawyerAdvisoryServicesReservations::findOrFail($id);
        $ClientAdvisoryServicesReservations->update([
            'transaction_complete' => 2
        ]);
        return view('site.api.cancelPaymentLawyer');
    }

    public function DeclinedPaymentClientAdvisoryServicesRequests(Request $request, $id)
    {
        $ClientAdvisoryServicesReservations = LawyerAdvisoryServicesReservations::findOrFail($id);
        $ClientAdvisoryServicesReservations->update([
            'transaction_complete' => 3
        ]);
        return view('site.api.declinedPaymentLawyer');
    }

}
