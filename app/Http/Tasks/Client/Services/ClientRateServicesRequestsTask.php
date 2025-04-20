<?php

namespace App\Http\Tasks\Client\Services;

use App\Http\Requests\API\Client\AdvisoryService\ClientCancelAppointmentAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Client\AdvisoryService\ClientRateAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Client\Services\ClientRateServicesRequestsRequest;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationsRates;
use App\Models\Client\ClientRequest;
use App\Models\Client\ClientRequestRates;

class ClientRateServicesRequestsTask extends BaseTask
{

    public function run(ClientRateServicesRequestsRequest $request)
    {
        $client = $this->authClient();
        $reservation = ClientRequest::where('client_id', $client->id)->where('id', $request->client_service_request_id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, '! الطلب غير موجود ', null, 404);
        }
        if ($reservation->request_status != 2) {
            return $this->sendResponse(false, '! الطلب غير مكتمل بعد ', null, 402);
        }
        $reservations_rates = ClientRequestRates::where('client_id', $client->id)->where('client_service_request_id', $request->client_service_request_id)->first();
        if (is_null($reservations_rates)) {
            ClientRequestRates::create([
                'client_service_request_id' => $request->client_service_request_id,
                'client_id' => $client->id,
                'rate' => $request->rate,
                'comment' => $request->comment
            ]);
            return $this->sendResponse(true, 'تم تقييم الطلب بنجاح ', null, 200);

        } else {
            return $this->sendResponse(false, 'تم تقييم الطلب من قبل', null, 402);

        }
    }
}
