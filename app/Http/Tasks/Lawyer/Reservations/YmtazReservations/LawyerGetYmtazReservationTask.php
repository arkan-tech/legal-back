<?php

namespace App\Http\Tasks\Lawyer\Reservations\YmtazReservations;

use App\Http\Requests\API\Client\AdvisoryService\ClientCreateAdvisoryServiceReservationRequest;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Resources\API\Client\Reservations\YmtazReservations\ClientYmtazReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\YmtazReservations\YmtazLawyerReservations;
use App\Models\YmtazReservations\YmtazReservations;

class LawyerGetYmtazReservationTask extends BaseTask
{

    public function run()
    {
        $lawyer = $this->authLawyer();

        $reservations = YmtazLawyerReservations::where('transaction_complete', 1)->where('lawyer_id', $lawyer->id)->orderBy('created_at', 'desc')->get();

        $reservations = ClientYmtazReservationResource::collection($reservations);
        return $this->sendResponse(true, ' قائمة  الحجوزات مع يمتاز', compact('reservations'), 200);
    }
}
