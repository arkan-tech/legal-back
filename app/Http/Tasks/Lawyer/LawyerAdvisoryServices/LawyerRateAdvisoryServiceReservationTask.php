<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\LawyerRateAdvisoryServiceReservationRequest;
use App\Http\Tasks\BaseTask;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationsRates;

class LawyerRateAdvisoryServiceReservationTask extends BaseTask
{

    public function run(LawyerRateAdvisoryServiceReservationRequest $request)
    {
        $lawyer = $this->authLawyer();
        $reservation = LawyerAdvisoryServicesReservations::where('reserved_lawyer_id', $lawyer->id)->where('id', $request->client_advisory_services_reservation_id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, '! الاستشارة غير موجودة  ', null, 404);
        }
        if ($reservation->reservation_status != 5) {
            return $this->sendResponse(false, '! الاستشارة غير مكتملة بعد ', null, 402);
        }
        $reservations_rates = LawyerAdvisoryServicesReservationsRates::where('lawyer_id', $lawyer->id)->where('lawyer_advisory_services_reservation_id', $request->client_advisory_services_reservation_id)->first();
        if (is_null($reservations_rates)) {
            LawyerAdvisoryServicesReservationsRates::create([
                'lawyer_advisory_services_reservation_id' => $request->client_advisory_services_reservation_id,
                'lawyer_id' => $lawyer->id,
                'rate' => $request->rate,
                'comment' => $request->comment
            ]);
            return $this->sendResponse(true, 'تم تقييم الاستشارة بنجاح ', null, 200);

        } else {
            return $this->sendResponse(false, 'تم تقييم الاستشارة من قبل', null, 402);

        }
    }
}
