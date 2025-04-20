<?php

namespace App\Http\Controllers\API\Client\AdvisoryServices;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Models\AdvisoryServicesReservations;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Tasks\Client\ContactYmtaz\ClientGetContactYmtazTask;
use App\Models\AdvisoryServices\ClientAdvisoryServicesAppointment;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Http\Tasks\Client\ContactYmtaz\ClientSaveContactMessageTask;
use App\Http\Requests\API\Client\ContactYmtaz\SaveContactMessageRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Tasks\Client\AdvisoryServices\ClientGetAdvisoryServicesTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientGetAdvisoryServicesTypesTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientListAdvisoryServicesBaseTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientListAdvisoryServiceReservationTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientRateAdvisoryServiceReservationTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientDelayAdvisoryServiceReservationTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientCreateAdvisoryServiceReservationTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientListAdvisoryTypesByAdvisoryServiceId;
use App\Http\Tasks\Client\AdvisoryServices\ClientGetAdvisoryServicesPaymentMethodsTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientGetLawyersByAdvisoryServiceTypeIdTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientListAdvisoryServicesBasePaymentMethodTask;
use App\Http\Requests\API\Client\AdvisoryService\ClientRateAdvisoryServiceReservationRequest;
use App\Http\Tasks\Client\AdvisoryServices\CompletePaymentClientAdvisoryServicesRequestsTask;
use App\Http\Requests\API\Client\AdvisoryService\ClientDelayAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Client\AdvisoryService\ClientCreateAdvisoryServiceReservationRequest;
use App\Http\Tasks\Client\AdvisoryServices\ClientGetAdvisoryServicesPaymentCategoriesTypesTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientListAdvisoryServiceReservationFromLawyersTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientDelayAppointmentAdvisoryServiceReservationTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientCancelAppointmentAdvisoryServiceReservationTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientListAdvisoryServicesPaymentCategoriesByBaseIdTask;
use App\Http\Requests\API\Client\AdvisoryService\ClientDelayAppointmentAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Client\AdvisoryService\ClientCancelAppointmentAdvisoryServiceReservationRequest;
use App\Http\Tasks\Client\AdvisoryServices\ClientGetAdvisoryServicesGeneralCategoriesTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientGetAdvisoryServicesGeneralCategoriesSubTask;
use App\Http\Tasks\Client\AdvisoryServices\ClientGetLawyersByAdvisoryServiceGeneralSubIdTask;

class ClientAdvisoryServicesController extends BaseController
{
    public function ListAdvisoryServices(Request $request, ClientGetAdvisoryServicesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function ListAdvisoryTypesByAdvisoryServiceId(Request $request, ClientListAdvisoryTypesByAdvisoryServiceId $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function ListAdvisoryServicesTypes(Request $request, ClientGetAdvisoryServicesTypesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function ListAdvisoryServicesBase(Request $request, ClientListAdvisoryServicesBaseTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function ListAdvisoryServicesPaymentCategoriesByBaseId(Request $request, ClientListAdvisoryServicesPaymentCategoriesByBaseIdTask $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function paymentMethods(Request $request, ClientGetAdvisoryServicesPaymentMethodsTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function paymentCategoriesTypes(Request $request, ClientGetAdvisoryServicesPaymentCategoriesTypesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function ListAdvisoryServicesBasePaymentMethod(Request $request, ClientListAdvisoryServicesBasePaymentMethodTask $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CreateAdvisoryServices(ClientCreateAdvisoryServiceReservationRequest $request, ClientCreateAdvisoryServiceReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function AppointmentAdvisoryServices(ClientDelayAdvisoryServiceReservationRequest $request, ClientDelayAdvisoryServiceReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function RateAdvisoryServicesReservation(ClientRateAdvisoryServiceReservationRequest $request, ClientRateAdvisoryServiceReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function ListClientAdvisoryServicesRequests(Request $request, ClientListAdvisoryServiceReservationTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function ListClientAdvisoryServicesRequestsFromLawyers(Request $request, ClientListAdvisoryServiceReservationFromLawyersTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function DelayClientAdvisoryServicesRequests(ClientDelayAppointmentAdvisoryServiceReservationRequest $request, ClientDelayAppointmentAdvisoryServiceReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CancelClientAdvisoryServicesRequests(ClientCancelAppointmentAdvisoryServiceReservationRequest $request, ClientCancelAppointmentAdvisoryServiceReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getLawyersByAdvisoryServiceTypeId(Request $request, $sub_id, ClientGetLawyersByAdvisoryServiceTypeIdTask $task)
    {
        $response = $task->run($request, $sub_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CompletePaymentClientAdvisoryServicesRequests(Request $request, $id)
    {
        $ClientAdvisoryServicesReservations = ClientAdvisoryServicesReservations::findOrFail($id);
        $ClientAdvisoryServicesReservations->update([
            'transaction_complete' => 1
        ]);
        return view('site.api.completePayment');
    }

    public function CancelPaymentClientAdvisoryServicesRequests(Request $request, $id)
    {
        $ClientAdvisoryServicesReservations = ClientAdvisoryServicesReservations::findOrFail($id);
        $ClientAdvisoryServicesReservations->update([
            'transaction_complete' => 2
        ]);
        return view('site.api.cancelPayment');
    }

    public function DeclinedPaymentClientAdvisoryServicesRequests(Request $request, $id)
    {
        $ClientAdvisoryServicesReservations = ClientAdvisoryServicesReservations::findOrFail($id);
        $ClientAdvisoryServicesReservations->update([
            'transaction_complete' => 3
        ]);
        return view('site.api.declinedPayment');
    }

    public function getAdvisoryServicesGeneralCategories($id, ClientGetAdvisoryServicesGeneralCategoriesTask $task)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getAdvisoryServicesGeneralCategoriesSub($id, $g_id, ClientGetAdvisoryServicesGeneralCategoriesSubTask $task)
    {
        $response = $task->run($id, $g_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getLawyersByAdvisoryServiceGeneralSubId($id, $g_id, $s_id, ClientGetLawyersByAdvisoryServiceGeneralSubIdTask $task)
    {
        $response = $task->run($id, $g_id, $s_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getReservationById($id)
    {
        $client = $this->authAccount();

        $reservation = AdvisoryServicesReservations::where('id', '18')
            ->where('account_id', $client->id)->orWhere('reserved_from_lawyer_id', $client->id)
            ->firstOrFail();

        $reservation = new AdvisoryServicesReservationResource($reservation);
        return $this->sendResponse(true, 'Advisory reservation fetched successfully.', ['reservation' => $reservation], 200);
    }

}
