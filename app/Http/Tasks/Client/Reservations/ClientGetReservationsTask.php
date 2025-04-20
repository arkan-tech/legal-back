<?php

namespace App\Http\Tasks\Client\Reservations;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;

class ClientGetReservationsTask extends BaseTask
{

    public function run()
    {
        $client = $this->authClient();
        $reservations = ClientReservations::with('ClientAdvisoryServicesReservations')->where('client_id', $client->id)->orderBy('created_at', 'desc')->get();

        $reservations_list = [];

        foreach ($reservations as $reservation) {
            if ($reservation->reservation_with_ymtaz == 1) {
                if ($reservation->ClientAdvisoryServicesReservations->transaction_complete == 1) {
                    array_push($reservations_list, $reservation);
                }
            } else {
                array_push($reservations_list, $reservation);
            }
        }
        $reservations = $reservations_list;
        $reservations = ClientReservationsResource::collection($reservations);
        return $this->sendResponse(true, 'مواعيد خاصة', compact('reservations'), 200);
    }
}
