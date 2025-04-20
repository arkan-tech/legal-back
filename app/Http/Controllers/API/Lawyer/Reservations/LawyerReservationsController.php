<?php

namespace App\Http\Controllers\API\Lawyer\Reservations;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Lawyer\Reservations\LawyerGetReservationsTask;
use App\Http\Tasks\Client\Reservations\ClientCancelReservationTask;
use App\Http\Tasks\Lawyer\Reservations\LawyerCancelReservationTask;
use App\Http\Tasks\Lawyer\Reservations\LawyerUpdateReservationTask;
use App\Http\Tasks\Lawyer\NewReservations\HideReservationsPriceTask;
use App\Http\Tasks\Lawyer\NewReservations\DeleteReservationsPriceTask;
use App\Http\Tasks\Lawyer\NewReservations\LawyerCreateReservationTask;
use App\Http\Tasks\Lawyer\NewReservations\LawyerGetMyReservationsTask;
use App\Http\Tasks\Lawyer\NewReservations\LawyerChangeReservationStatus;
use App\Http\Tasks\Lawyer\NewReservations\LawyerGetReservationTypesTask;
use App\Http\Tasks\Lawyer\NewReservations\LawyerCreateReservationPriceTask;
use App\Http\Tasks\Lawyer\NewReservations\LawyerGetMyReservationsTaskClient;
use App\Http\Tasks\Lawyer\NewReservations\LawyerGetMyReservationsTaskLawyer;
use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\LawyerCreateReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\LawyerUpdateReservationRequest;
use App\Http\Tasks\Lawyer\NewReservations\LawyerGetReservationImportanceTask;
use App\Http\Tasks\Lawyer\NewReservations\LawyerGetReservationTypeImportanceTask;
use App\Http\Tasks\Lawyer\Reservations\RequestedFromLawyer\GetMyReservationByIdTask;
use App\Http\Tasks\Lawyer\Reservations\RequestedFromLawyer\LawyerGetReservationsRequestedFromLawyerTask;

class LawyerReservationsController extends BaseController
{
    public function list(Request $request, LawyerGetReservationsTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function listRequestedFromLawyerReservations(Request $request, LawyerGetReservationsRequestedFromLawyerTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getMyReservationById(Request $request, GetMyReservationByIdTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function create(LawyerCreateReservationRequest $request, LawyerCreateReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function update(LawyerUpdateReservationRequest $request, LawyerUpdateReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function cancel(Request $request, LawyerCancelReservationTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function endReservation(Request $request, LawyerChangeReservationStatus $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function createReservationPrice(Request $request, LawyerCreateReservationPriceTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function createReservation(Request $request, LawyerCreateReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getMyReservationsClient(Request $request, LawyerGetMyReservationsTaskClient $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getMyReservationsLawyer(Request $request, LawyerGetMyReservationsTaskLawyer $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getReservationImportance(Request $request, LawyerGetReservationImportanceTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getReservationTypeImportance(Request $request, LawyerGetReservationTypeImportanceTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function deleteReservationTypePrice(Request $request, DeleteReservationsPriceTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function changeReservationTypePriceStatus(Request $request, HideReservationsPriceTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getReservationTypes(Request $request, LawyerGetReservationTypesTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
}
