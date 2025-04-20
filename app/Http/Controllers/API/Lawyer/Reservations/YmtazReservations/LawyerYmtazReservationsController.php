<?php

namespace App\Http\Controllers\API\Lawyer\Reservations\YmtazReservations;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Lawyer\Reservations\YmtazReservations\LawyerCreateYmtazReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\YmtazReservations\LawyerRateYmtazReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\YmtazReservations\LawyerUpdateYmtazReservationRequest;
use App\Http\Tasks\Lawyer\Reservations\YmtazReservations\LawyerCancelYmtazReservationTask;
use App\Http\Tasks\Lawyer\Reservations\YmtazReservations\LawyerCreateYmtazReservationTask;
use App\Http\Tasks\Lawyer\Reservations\YmtazReservations\LawyerGetYmtazReservationTask;
use App\Http\Tasks\Lawyer\Reservations\YmtazReservations\LawyerRateYmtazReservationTask;
use App\Http\Tasks\Lawyer\Reservations\YmtazReservations\LawyerUpdateYmtazReservationTask;
use App\Http\Tasks\Lawyer\Reservations\YmtazReservations\LawyerViewYmtazReservationTask;
use App\Models\YmtazReservations\YmtazLawyerReservations;
use Illuminate\Http\Request;

class LawyerYmtazReservationsController extends BaseController
{
    public function list(Request $request, LawyerGetYmtazReservationTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function create(LawyerCreateYmtazReservationRequest $request, LawyerCreateYmtazReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function view(Request $request,  LawyerViewYmtazReservationTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function update(LawyerUpdateYmtazReservationRequest $request, LawyerUpdateYmtazReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function cancel(Request $request,  LawyerCancelYmtazReservationTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function rate(LawyerRateYmtazReservationRequest $request,  LawyerRateYmtazReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }


    public function CompletePaymentClientServicesRequests($id)
    {
        $reservation = YmtazLawyerReservations::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 1
        ]);
        return view('site.api.completePayment');
    }

    public function CancelPaymentClientServicesRequests($id)
    {
        $reservation = YmtazLawyerReservations::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 2,
            'status' => 3,
        ]);
        return view('site.api.cancelPaymentLawyer');
    }

    public function DeclinedPaymentClientServicesRequests($id)
    {
        $reservation = YmtazLawyerReservations::findOrFail($id);
        $reservation->update([
            'transaction_complete' => 3,
            'status' => 3,
        ]);
        return view('site.api.declinedPaymentLawyer');
    }
}
