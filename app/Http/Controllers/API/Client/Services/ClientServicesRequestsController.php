<?php

namespace App\Http\Controllers\API\Client\Services;

use App\Http\Resources\ServicesReservationsResource;
use Illuminate\Http\Request;
use App\Models\Client\ClientRequest;
use App\Models\ServicesReservations;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\Services\ClientGetServicesTask;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Tasks\Client\Services\ClientRateServicesRequestsTask;
use App\Http\Tasks\Client\Services\ClientGetLawyersByServiceIdTask;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Http\Tasks\Client\Services\ClientCreateServicesRequestsTask;
use App\Http\Tasks\Client\Services\ClientGetServicesRequestsListTask;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Requests\API\Client\Services\ClientRateServicesRequestsRequest;
use App\Http\Requests\API\Client\Services\ClientCreateServicesRequestsRequest;

class ClientServicesRequestsController extends BaseController
{
    public function create(ClientCreateServicesRequestsRequest $request, ClientCreateServicesRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function list(Request $request, ClientGetServicesRequestsListTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function rate(ClientRateServicesRequestsRequest $request, ClientRateServicesRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getLawyersByServiceId(Request $request, $service_id, ClientGetLawyersByServiceIdTask $task)
    {
        $response = $task->run($request, $service_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CompletePaymentClientServicesRequests(Request $request, $id)
    {
        $ClientAdvisoryServicesRequests = ClientRequest::findOrFail($id);
        $ClientAdvisoryServicesRequests->update([
            'transaction_complete' => 1
        ]);
        return view('site.api.completePayment');
    }
    public function CancelPaymentClientServicesRequests(Request $request, $id)
    {
        $ClientAdvisoryServicesRequests = ClientRequest::findOrFail($id);
        $ClientAdvisoryServicesRequests->update([
            'transaction_complete' => 2
        ]);
        return view('site.api.cancelPayment');
    }
    public function DeclinedPaymentClientServicesRequests(Request $request, $id)
    {
        $ClientAdvisoryServicesRequests = ClientRequest::findOrFail($id);
        $ClientAdvisoryServicesRequests->update([
            'transaction_complete' => 3
        ]);
        return view('site.api.declinedPayment');
    }

    public function getReservationById($id)
    {
        $client = $this->authAccount();

        $reservation = ServicesReservations::where('id', $id)
            ->where('account_id', $client->id)->orWhere('reserved_from_lawyer_id', $client->id)
            ->firstOrFail();

        $reservation = new ServicesReservationsResource($reservation);
        return $this->sendResponse(true, 'Reservation fetched successfully.', ['reservation' => $reservation], 200);
    }

}
