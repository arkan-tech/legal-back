<?php

namespace App\Http\Tasks\Client\LawyerReservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientLawyerReservationsResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientLawyerReservations;
use App\Models\ClientReservations\ClientReservations;
use Illuminate\Http\Request;

class ClientCancelServicesReservationsLawyerTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $client = $this->authClient();
        $reservation = ClientLawyerReservations::where('client_id', $client->id)->where('id', $id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, ' الحجز غير موجود', null, 404);
        }
        $reservation->update([
            'complete_status' => 2
        ]);

        $reservation = new ClientLawyerReservationsResource($reservation);
        return $this->sendResponse(true, '   تم الغاء الموعد بنجاح', compact('reservation'), 200);
    }
}
