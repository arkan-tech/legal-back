<?php

namespace App\Http\Controllers\API\Lawyer\ServicesReservations;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Lawyer\ServicesReservations\LawyerCreateServicesReservationsLawyerRequest;
use App\Http\Tasks\Client\Lawyer\ClientGetLawyerServicesTask;
use App\Http\Tasks\Lawyer\LawyerReservations\LawyerCancelServicesReservationsLawyerTask;
use App\Http\Tasks\Lawyer\LawyerReservations\LawyerGetServicesReservationsLawyerTask;
use App\Http\Tasks\Lawyer\ServicesReservations\LawyerCreateServicesReservationsLawyerTask;
use App\Models\Client\ClientLawyerReservations;
use App\Models\Lawyer\LawyerReservationsLawyer;
use Illuminate\Http\Request;


class LawyerServicesLawyerReservationsController extends BaseController
{
    public function getServices(Request $request, ClientGetLawyerServicesTask $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CreateServicesReservations(LawyerCreateServicesReservationsLawyerRequest $request, LawyerCreateServicesReservationsLawyerTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function GetServicesReservations(Request $request, LawyerGetServicesReservationsLawyerTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CancelServicesReservations(Request $request, LawyerCancelServicesReservationsLawyerTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CompletePaymentClientServicesRequests($id)
    {
        $reservation = LawyerReservationsLawyer::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 1
        ]);
        return view('site.api.completePayment');
    }

    public function CancelPaymentClientServicesRequests($id)
    {
        $reservation = LawyerReservationsLawyer::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 2
        ]);
        return view('site.api.cancelPayment');
    }

    public function DeclinedPaymentClientServicesRequests($id)
    {
        $reservation = LawyerReservationsLawyer::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 0,
            'complete_status' => 3,
        ]);
        return view('site.api.declinedPaymentLawyer');
    }

}
