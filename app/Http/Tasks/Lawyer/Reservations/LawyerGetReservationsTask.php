<?php

namespace App\Http\Tasks\Lawyer\Reservations;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Lawyer\Reservations\LawyerReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\LawyerReservations\LawyerReservations;

class LawyerGetReservationsTask extends BaseTask
{

    public function run()
    {
        $lawyer = $this->authLawyer();
        $reservations = LawyerReservations::with('ClientAdvisoryServicesReservations')->where('reserved_lawyer_id', $lawyer->id)->orderBy('created_at', 'desc')->get();

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
        $reservations = LawyerReservationsResource::collection($reservations);
        return $this->sendResponse(true, 'مواعيد خاصة', compact('reservations'), 200);
    }
}
