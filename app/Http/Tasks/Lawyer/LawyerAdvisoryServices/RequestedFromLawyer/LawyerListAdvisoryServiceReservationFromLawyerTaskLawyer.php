<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices\RequestedFromLawyer;

use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\Lawyer\LawyerCreateReservationLawyerRequest;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\Lawyer\Lawyer;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use Exception;
use Illuminate\Http\Request;

class LawyerListAdvisoryServiceReservationFromLawyerTaskLawyer extends BaseTask
{

    public function run(Request $request)
    {
        $Lawyer = $this->authLawyer();

        $reservations = LawyerAdvisoryServicesReservations::where('transaction_complete', 1)->where('lawyer_id', $Lawyer->id)->orderBy('created_at', 'desc')->get();

        $reservations = AdvisoryServicesReservationResource::collection($reservations);
        return $this->sendResponse(true, '  قائمة طلبات الاستشارات مطلوبة من مقدم الخدمة', compact('reservations'), 200);

    }
}
