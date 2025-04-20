<?php

namespace App\Http\Controllers\API\Client\Lawyer;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\Lawyer\ClientGetLawyersTask;
use App\Http\Tasks\Client\Lawyer\ClientLawyerProfileTask;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Lawyer\ClientGetLawyerClientsTask;
use App\Http\Tasks\Client\Lawyer\ClientGetLawyerServicesTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Tasks\Client\Lawyer\Rate\ClientCreateLawyerRateTask;
use App\Http\Tasks\Client\Lawyer\ClientGetLawyerAdvisoryServicesTask;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Tasks\Client\FavoritesLawyers\ClientAddFavoritesLawyersTask;
use App\Http\Tasks\Client\FavoritesLawyers\ClientListFavoritesLawyersTask;
use App\Http\Requests\API\Client\Lawyer\Rate\ClientCreateLawyerRateRequest;
use App\Http\Requests\API\Client\FavoritesLawyers\ClientAddFavoritesLawyersRequest;
use App\Http\Tasks\Client\AdvisoryServices\Lawyer\ClientCreateLawyerReservationTask;
use App\Http\Requests\API\Client\AdvisoryService\Lawyer\ClientCreateReservationLawyerRequest;

class ClientLawyersController extends BaseController
{
    public function getProfile(Request $request, ClientLawyerProfileTask $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getProfileClients(Request $request, ClientGetLawyerClientsTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getProfileLawyers(Request $request, ClientGetLawyersTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }


    public function ListFavoritesLawyers(Request $request, ClientListFavoritesLawyersTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function AddFavoritesLawyers(ClientAddFavoritesLawyersRequest $request, ClientAddFavoritesLawyersTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CreateAdvisoryServicesReservations(ClientCreateReservationLawyerRequest $request, ClientCreateLawyerReservationTask $task)
    {

        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getServices(Request $request, ClientGetLawyerServicesTask $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getAdvisoryServices(Request $request, ClientGetLawyerAdvisoryServicesTask $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function CreateLawyerRate(ClientCreateLawyerRateRequest $request, ClientCreateLawyerRateTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

}
