<?php

namespace App\Http\Tasks\Lawyer\Reservations\RequestedFromLawyer;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use App\Http\Tasks\BaseTask;
use App\Models\ClientReservations\ClientReservations;
use App\Models\ClientReservations\ClientReservationsImportance;
use Illuminate\Http\Request;

class LawyerGetReservationsRequestedFromLawyerTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = $this->authLawyer();
        $reservations = ClientReservations::with('ClientAdvisoryServicesReservations')->where('lawyer_id', $lawyer->id)->orderBy('created_at', 'desc')->get();

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
        return $this->sendResponse(true, 'مواعيد خاصة مطلوبة من مقدم الخدمة', compact('reservations'), 200);
    }
}
