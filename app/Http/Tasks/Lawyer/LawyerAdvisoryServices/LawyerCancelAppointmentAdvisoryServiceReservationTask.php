<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\LawyerCancelAppointmentAdvisoryServiceReservationRequest;
use App\Http\Resources\API\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;

class LawyerCancelAppointmentAdvisoryServiceReservationTask extends BaseTask
{

    public function run(LawyerCancelAppointmentAdvisoryServiceReservationRequest $request)
    {
        $reservation = LawyerAdvisoryServicesReservations::findOrFail($request->reservation_id);
        if ($reservation->reservation_status == 7) {
            return $this->sendResponse(false, 'لا يمكن الغاء الاستشارة لانه تم الغاء الاستشارة مسبقاً ', null, 401);
        }
        if ($reservation->reservation_status != 5) {
            $reservation->update([
                'reservation_status' => 7
            ]);
            $reservation = new LawyerAdvisoryServicesReservationResource($reservation);
            return $this->sendResponse(true, 'تم الغاء الاستشارة', compact('reservation'), 200);
        } else {
            return $this->sendResponse(false, 'لا يمكن الغاء الاستشارة لانه تم الرد واكتمال الاستشارة', null, 401);

        }

    }
}
