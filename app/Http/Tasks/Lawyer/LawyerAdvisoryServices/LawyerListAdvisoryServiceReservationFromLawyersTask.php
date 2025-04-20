<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Http\Tasks\BaseTask;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Http\Resources\API\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationResource;

class LawyerListAdvisoryServiceReservationFromLawyersTask extends BaseTask
{

    public function run()
    {
        $lawyer = $this->authLawyer();

        $reservations = LawyerAdvisoryServicesReservations::where('transaction_complete', 1)->where('reserved_lawyer_id', $lawyer->id)->whereNotNull('lawyer_id')->with('service')->orderBy('created_at', 'desc')->get();

        $reservations = LawyerAdvisoryServicesReservationResource::collection($reservations);
        return $this->sendResponse(true, 'قائمة طلبات الاستشارات من مقدمي الخدمة', compact('reservations'), 200);

    }
}
