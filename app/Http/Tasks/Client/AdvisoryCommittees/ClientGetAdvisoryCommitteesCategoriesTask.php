<?php

namespace App\Http\Tasks\Client\AdvisoryCommittees;

use App\Http\Requests\API\Client\AdvisoryService\ClientCancelAppointmentAdvisoryServiceReservationRequest;
use App\Http\Resources\API\AdvisoryCommittees\AdvisoryCommitteesResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;

class ClientGetAdvisoryCommitteesCategoriesTask extends BaseTask
{

    public function run()
    {
        $categories =AdvisoryCommitteesResource::collection(AdvisoryCommittee::where('status', 1)->orderBy('created_at','desc')->get()) ;
        return $this->sendResponse(true, 'هيئات المستشارين', compact('categories'), 200);

    }
}
