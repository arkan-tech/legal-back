<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\CreateRequestValidation;
use App\Http\Tasks\Reservations\ConfirmOfferTask;
use App\Http\Tasks\Reservations\CreateRequestTask;
use App\Http\Tasks\Reservations\ReplyWithOfferTask;
use App\Http\Tasks\Reservations\GetSubCategoriesTask;
use App\Http\Tasks\Reservations\GetMainCategoriesTask;
use App\Http\Tasks\Reservations\GetMyRequestedRequestsTask;
use App\Http\Tasks\Reservations\ConfirmReservationEndingTask;
use App\Http\Tasks\Reservations\GetLawyersBySubCategoryIdTask;
use App\Http\Tasks\Reservations\GetLawyersByMainCategoryIdTask;
use App\Http\Tasks\Reservations\GetMyRequestedReservationsTask;
use App\Http\Tasks\Reservations\GetRequestedReservationsFromMeTask;

class ReservationsController extends BaseController
{
    public function MainCategories(Request $request, GetMainCategoriesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function SubCategories(Request $request, GetSubCategoriesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getLawyersByMainCategoryId(Request $request, $sub_category_id, GetLawyersByMainCategoryIdTask $task)
    {
        $response = $task->run($request, $sub_category_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function createRequest(CreateRequestValidation $request, CreateRequestTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function replyWithOffer(Request $request, ReplyWithOfferTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function confirmOffer(Request $request, ConfirmOfferTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getMyRequestedRequests(Request $request, GetMyRequestedRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getMyRequestedReservations(Request $request, GetMyRequestedReservationsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getRequestedReservationsFromMe(Request $request, GetRequestedReservationsFromMeTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function confirmReservationEnding(Request $request, ConfirmReservationEndingTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
