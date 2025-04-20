<?php

namespace App\Http\Tasks\Lawyer\Reservations\YmtazReservations;

use App\Http\Requests\API\Client\AdvisoryService\ClientCancelAppointmentAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Client\AdvisoryService\ClientRateAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Client\Reservations\YmtazReservations\ClientRateYmtazReservationRequest;
use App\Http\Requests\API\Client\Services\ClientRateServicesRequestsRequest;
use App\Http\Requests\API\Lawyer\Reservations\YmtazReservations\LawyerRateYmtazReservationRequest;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationsRates;
use App\Models\Client\ClientRequest;
use App\Models\Client\ClientRequestRates;
use App\Models\YmtazReservations\YmtazLawyerReservations;
use App\Models\YmtazReservations\YmtazReservations;

class LawyerRateYmtazReservationTask extends BaseTask
{

    public function run(LawyerRateYmtazReservationRequest $request)
    {
        $lawyer = $this->authLawyer();
        $reservation = YmtazLawyerReservations::where('lawyer_id', $lawyer->id)->where('id', $request->reservation_id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, '! الحجز غير موجود ', null, 404);
        }
        if ($reservation->status != 2) {
            return $this->sendResponse(false, '! الحجز غير مكتمل بعد ', null, 402);
        }
        if (!is_null($reservation->rate)) {
            return $this->sendResponse(false, '! الحجز تم تقييمه مسبقاً ', null, 402);
        }

        $reservation->update([
           'rate'=>$request->rate ,
           'comment'=>$request->comment ,
        ]);
        return $this->sendResponse(true, 'تم تقييم الحجز بنجاح ', null, 200);


    }
}
