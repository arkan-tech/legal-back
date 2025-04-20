<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationReply;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationResource;

class ListRequestedByIdTask extends BaseTask
{

    public function run($id)
    {
        $lawyer = $this->authLawyer();

        $advisory_service_request = ClientAdvisoryServicesReservations::where('transaction_complete', 1)->where('transaction_complete', 1)->where('lawyer_id', $lawyer->id)->orderBy('created_at', 'desc')->findOrFail($id);
        if (is_null($advisory_service_request)) {
            $advisory_service_request = LawyerAdvisoryServicesReservations::where('transaction_complete', 1)->where('transaction_complete', 1)->where('lawyer_id', $lawyer->id)->orderBy('created_at', 'desc')->findOrFail($id);
        } else {
        }
        $advisory_service_request = new AdvisoryServicesReservationResource($advisory_service_request);
        return $this->sendResponse(true, 'الطلب', compact('advisory_service_request'), 200);

    }
}
