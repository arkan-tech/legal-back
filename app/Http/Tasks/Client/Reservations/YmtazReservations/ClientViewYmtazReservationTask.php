<?php

namespace App\Http\Tasks\Client\Reservations\YmtazReservations;

use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Client\Reservations\YmtazReservations\ClientYmtazReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\YmtazReservations\YmtazReservations;
use Illuminate\Http\Request;

class ClientViewYmtazReservationTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $client = $this->authClient();
        $reservation = YmtazReservations::where('id', $id)->where('transaction_complete', 1)->where('client_id', $client->id)->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, ' الحجز غير موجود', null, 404);
        }

        $reservation = new ClientYmtazReservationResource($reservation);
        return $this->sendResponse(true, '   معلومات الحجز', compact('reservation'), 200);
    }
}
