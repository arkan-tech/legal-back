<?php

namespace App\Http\Controllers\API\Client\ServicesReservations;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Client\ServicesReservations\ClientCreateServicesReservationsLawyerRequest;
use App\Http\Tasks\Client\Lawyer\ClientGetLawyerServicesTask;
use App\Http\Tasks\Client\LawyerReservations\ClientCancelServicesReservationsLawyerTask;
use App\Http\Tasks\Client\LawyerReservations\ClientGetServicesReservationsLawyerTask;
use App\Http\Tasks\Client\ServicesReservations\ClientCreateServicesReservationsLawyerTask;
use App\Models\Client\ClientLawyerReservations;
use App\Models\Client\ClientRequest;
use Illuminate\Http\Request;


class ClientServicesLawyerReservationsController extends BaseController
{
    public function getServices(Request $request, ClientGetLawyerServicesTask $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CreateServicesReservations(ClientCreateServicesReservationsLawyerRequest $request, ClientCreateServicesReservationsLawyerTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function GetServicesReservations(Request $request, ClientGetServicesReservationsLawyerTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CancelServicesReservations(Request $request, ClientCancelServicesReservationsLawyerTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CompletePaymentClientServicesRequests($id)
    {
        $reservation = ClientLawyerReservations::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 1
        ]);
        return view('site.api.completePayment');
    }

    public function CancelPaymentClientServicesRequests($id)
    {
        $reservation = ClientLawyerReservations::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 2
        ]);
        return view('site.api.cancelPayment');
    }

    public function DeclinedPaymentClientServicesRequests($id)
    {
        $reservation = ClientLawyerReservations::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 0,
            'complete_status' => 3,
        ]);
        return view('site.api.declinedPayment');
    }

}
