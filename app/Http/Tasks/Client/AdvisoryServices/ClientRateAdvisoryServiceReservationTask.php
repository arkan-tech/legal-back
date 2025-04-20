<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Requests\API\Client\AdvisoryService\ClientCancelAppointmentAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Client\AdvisoryService\ClientRateAdvisoryServiceReservationRequest;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationsRates;

class ClientRateAdvisoryServiceReservationTask extends BaseTask
{

    public function run(ClientRateAdvisoryServiceReservationRequest $request)
    {
        $client = $this->authClient();
        $reservation = ClientAdvisoryServicesReservations::where('client_id', $client->id)->where('id', $request->client_advisory_services_reservation_id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, '! الاستشارة غير موجودة  ', null, 404);
        }
        if ($reservation->reservation_status != 5) {
            return $this->sendResponse(false, '! الاستشارة غير مكتملة بعد ', null, 402);
        }
        $reservations_rates = ClientAdvisoryServicesReservationsRates::where('client_id', $client->id)->where('client_advisory_services_reservation_id', $request->client_advisory_services_reservation_id)->first();
        if (is_null($reservations_rates)) {
            ClientAdvisoryServicesReservationsRates::create([
                'client_advisory_services_reservation_id' => $request->client_advisory_services_reservation_id,
                'client_id' => $client->id,
                'rate' => $request->rate,
                'comment' => $request->comment
            ]);
            return $this->sendResponse(true, 'تم تقييم الاستشارة بنجاح ', null, 200);

        } else {
            return $this->sendResponse(false, 'تم تقييم الاستشارة من قبل', null, 402);

        }
    }
}
