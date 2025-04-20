<?php

namespace App\Http\Controllers\API\Client\Reservations\YmtazReservations;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Client\Reservations\ClientUpdateReservationRequest;
use App\Http\Requests\API\Client\Reservations\YmtazReservations\ClientCreateYmtazReservationRequest;
use App\Http\Requests\API\Client\Reservations\YmtazReservations\ClientRateYmtazReservationRequest;
use App\Http\Requests\API\Client\Reservations\YmtazReservations\ClientUpdateYmtazReservationRequest;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use App\Http\Tasks\Client\Reservations\ClientCancelReservationTask;
use App\Http\Tasks\Client\Reservations\ClientCreateReservationTask;
use App\Http\Tasks\Client\Reservations\ClientGetReservationsTask;
use App\Http\Tasks\Client\Reservations\ClientUpdateReservationTask;
use App\Http\Tasks\Client\Reservations\Requirements\ClientGetImportanceTypeTask;
use App\Http\Tasks\Client\Reservations\Requirements\ClientGetReservationTypeTask;
use App\Http\Tasks\Client\Reservations\YmtazReservations\ClientCancelYmtazReservationTask;
use App\Http\Tasks\Client\Reservations\YmtazReservations\ClientCreateYmtazReservationTask;
use App\Http\Tasks\Client\Reservations\YmtazReservations\ClientGetYmtazReservationTask;
use App\Http\Tasks\Client\Reservations\YmtazReservations\ClientRateYmtazReservationTask;
use App\Http\Tasks\Client\Reservations\YmtazReservations\ClientUpdateYmtazReservationTask;
use App\Http\Tasks\Client\Reservations\YmtazReservations\ClientViewYmtazReservationTask;
use App\Models\Client\ClientLawyerReservations;
use App\Models\YmtazReservations\YmtazReservations;
use Illuminate\Http\Request;

class ClientYmtazReservationsController extends BaseController
{
    public function list(Request $request, ClientGetYmtazReservationTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function create(ClientCreateYmtazReservationRequest $request, ClientCreateYmtazReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function update(ClientUpdateYmtazReservationRequest $request, ClientUpdateYmtazReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function cancel(Request $request,  ClientCancelYmtazReservationTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function rate(ClientRateYmtazReservationRequest $request,  ClientRateYmtazReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
   public function view(Request $request,  ClientViewYmtazReservationTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }


    public function CompletePaymentClientServicesRequests($id)
    {
        $reservation = YmtazReservations::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 1
        ]);
        return view('site.api.completePayment');
    }

    public function CancelPaymentClientServicesRequests($id)
    {
        $reservation = YmtazReservations::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 2,
            'status' => 3,
        ]);
        return view('site.api.cancelPayment');
    }

    public function DeclinedPaymentClientServicesRequests($id)
    {
        $reservation = YmtazReservations::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 3,
            'status' => 3,
        ]);
        return view('site.api.declinedPayment');
    }
}
