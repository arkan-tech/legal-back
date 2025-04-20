<?php

namespace App\Http\Tasks\Client\AdvisoryCommittees;


use App\Http\Resources\API\AdvisoryCommittees\AdvisoryCommitteesWithAdvisorsResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Request;


class ClientAdvisoryCommitteesReservationsTask extends BaseTask
{

    public function run(Request $request)
    {
        $client = $this->authClient();
        $lawyers_ids = Lawyer::where('is_advisor', 1)->where('accepted', '2')->pluck('id')->toArray();
        $reservations = ClientAdvisoryServicesReservations::whereIN('lawyer_id',$lawyers_ids)->where('transaction_complete',1)->where('client_id',$client->id)->orderBy('created_at','desc')->get();

        $reservations=  AdvisoryServicesReservationResource::collection($reservations);
        return $this->sendResponse(true, ' قائمة طلبات الاستشارات', compact('reservations'), 200);

    }
}
