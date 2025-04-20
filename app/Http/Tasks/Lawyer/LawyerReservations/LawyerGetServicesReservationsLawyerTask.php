<?php

namespace App\Http\Tasks\Lawyer\LawyerReservations;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientLawyerReservationsResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Lawyer\Reservations\LawyerReservationsLawyerResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientLawyerReservations;
use App\Models\ClientReservations\ClientReservations;
use App\Models\Lawyer\LawyerReservationsLawyer;

class LawyerGetServicesReservationsLawyerTask extends BaseTask
{

    public function run()
    {
        $client = $this->authLawyer();
        $reservations = LawyerReservationsLawyer::where('reserved_lawyer_id', $client->id)->where('transaction_complete', 1)->orderBy('created_at', 'desc')->get();
        $reservations = LawyerReservationsLawyerResource::collection($reservations);
        return $this->sendResponse(true, ' حجوزات مقدمين الخدمة', compact('reservations'), 200);
    }
}
