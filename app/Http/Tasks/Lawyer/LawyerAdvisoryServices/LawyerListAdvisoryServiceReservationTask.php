<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;

class LawyerListAdvisoryServiceReservationTask extends BaseTask
{

    public function run()
    {
        $lawyer = $this->authLawyer();
        $reservations = LawyerAdvisoryServicesReservations::where('transaction_complete', 1)->where('reserved_lawyer_id', $lawyer->id)->whereNull('lawyer_id')->with('service')->orderBy('created_at', 'desc')->get();
        $reservations = LawyerAdvisoryServicesReservationResource::collection($reservations);
        return $this->sendResponse(true, 'قائمة طلبات الاستشارات من يمتاز', compact('reservations'), 200);

    }
}
