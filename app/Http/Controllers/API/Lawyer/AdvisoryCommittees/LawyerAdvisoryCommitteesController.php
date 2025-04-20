<?php

namespace App\Http\Controllers\API\Lawyer\AdvisoryCommittees;

use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\AdvisoryCommittees\ClientAdvisoryCommitteesReservationsTask;
use App\Http\Tasks\Client\AdvisoryCommittees\ClientgetAdvisorsBaseAdvisoryCommitteesCategoryIdTask;
use App\Http\Tasks\Client\AdvisoryCommittees\ClientGetAdvisoryCommitteesCategoriesTask;
use App\Http\Tasks\Lawyer\AdvisoryCommittees\LawyerAdvisoryCommitteesReservationsTask;
use Illuminate\Http\Request;

class LawyerAdvisoryCommitteesController extends BaseController
{

    public function listReservations(Request $request, LawyerAdvisoryCommitteesReservationsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }


}
