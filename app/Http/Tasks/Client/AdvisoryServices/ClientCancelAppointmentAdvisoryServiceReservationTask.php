<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Requests\API\Client\AdvisoryService\ClientCancelAppointmentAdvisoryServiceReservationRequest;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;

class ClientCancelAppointmentAdvisoryServiceReservationTask extends BaseTask
{

    public function run(ClientCancelAppointmentAdvisoryServiceReservationRequest $request)
    {
        $reservation = ClientAdvisoryServicesReservations::findOrFail($request->reservation_id);
        if ($reservation->reservation_status == 7) {
            return $this->sendResponse(false, 'لا يمكن الغاء الاستشارة لانه تم الغاء الاستشارة مسبقاً ', null, 401);

        }
        if ($reservation->reservation_status != 5) {
            $reservation->update([
                'reservation_status' => 7
            ]);
            $reservation = new AdvisoryServicesReservationResource($reservation);
            return $this->sendResponse(true, 'تم الغاء الاستشارة', compact('reservation'), 200);
        } else {
            return $this->sendResponse(false, 'لا يمكن الغاء الاستشارة لانه تم الرد واكتمال الاستشارة', null, 401);

        }

    }
}
