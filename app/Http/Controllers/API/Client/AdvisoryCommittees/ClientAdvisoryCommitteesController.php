<?php

namespace App\Http\Controllers\API\Client\AdvisoryCommittees;

use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\AdvisoryCommittees\ClientAdvisoryCommitteesReservationsTask;
use App\Http\Tasks\Client\AdvisoryCommittees\ClientgetAdvisorsBaseAdvisoryCommitteesCategoryIdTask;
use App\Http\Tasks\Client\AdvisoryCommittees\ClientGetAdvisoryCommitteesCategoriesTask;
use Illuminate\Http\Request;

class ClientAdvisoryCommitteesController extends BaseController
{
    public function getCategories(Request $request, ClientGetAdvisoryCommitteesCategoriesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getAdvisorsBaseCategoryId(Request $request, ClientgetAdvisorsBaseAdvisoryCommitteesCategoryIdTask $task,$id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function listReservations(Request $request, ClientAdvisoryCommitteesReservationsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }


}
