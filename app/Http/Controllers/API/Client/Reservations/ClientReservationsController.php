<?php

namespace App\Http\Controllers\API\Client\Reservations;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Client\Reservations\ClientUpdateReservationRequest;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use App\Http\Tasks\Client\Reservations\ClientCancelReservationTask;
use App\Http\Tasks\Client\Reservations\ClientCreateReservationTask;
use App\Http\Tasks\Client\Reservations\ClientGetReservationsTask;
use App\Http\Tasks\Client\Reservations\ClientUpdateReservationTask;
use App\Http\Tasks\Client\Reservations\Requirements\ClientGetImportanceTypeTask;
use App\Http\Tasks\Client\Reservations\Requirements\ClientGetReservationTypeTask;
use Illuminate\Http\Request;

class ClientReservationsController extends BaseController
{
    public function list(Request $request, ClientGetReservationsTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function create(ClientCreateReservationRequest $request, ClientCreateReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function update(ClientUpdateReservationRequest $request, ClientUpdateReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function cancel(Request $request, ClientCancelReservationTask $task ,$id)
    {
        $response = $task->run($request , $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    // Requirements
    public function ImportanceType(Request $request, ClientGetImportanceTypeTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function ReservationType(Request $request, ClientGetReservationTypeTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
}
