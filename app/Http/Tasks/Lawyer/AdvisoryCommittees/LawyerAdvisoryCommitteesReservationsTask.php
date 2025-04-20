<?php

namespace App\Http\Tasks\Lawyer\AdvisoryCommittees;


use App\Http\Resources\API\AdvisoryCommittees\AdvisoryCommitteesWithAdvisorsResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\Lawyer\Lawyer;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use Illuminate\Http\Request;


class LawyerAdvisoryCommitteesReservationsTask extends BaseTask
{

    public function run(Request $request)
    {
        $client = $this->authLawyer();
        $lawyers_ids = Lawyer::where('is_advisor', 1)->where('accepted', '2')->pluck('id')->toArray();
        $reservations = LawyerAdvisoryServicesReservations::whereIN('lawyer_id',$lawyers_ids)->where('transaction_complete',1)->where('reserved_lawyer_id',$client->id)->orderBy('created_at','desc')->get();
        $reservations=  LawyerAdvisoryServicesReservationResource::collection($reservations);
        return $this->sendResponse(true, ' قائمة طلبات الاستشارات', compact('reservations'), 200);

    }
}
