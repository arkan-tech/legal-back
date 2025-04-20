<?php

namespace App\Http\Resources\API\Reservations;

use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use Carbon\Carbon;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountResourcePublic;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerBasicDataResource;
use App\Http\Resources\API\Reservations\ReservationTypeShortResource;
use App\Http\Resources\API\Reservations\ReservationImportanceResource;

class ReservationResourceCodeFromReservation extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->reservation->id,
            'account' => new AccountResourcePublic($this->reservation->account),
            'description' => $this->reservation->description,
            'longitude' => $this->reservation->longitude,
            'latitude' => $this->reservation->latitude,
            'date' => $this->reservation->day,
            'from' => $this->reservation->from,
            'to' => $this->reservation->to,
            'country_id' => $this->reservation->country_id,
            'region_id' => $this->reservation->region_id,
            'file' => $this->reservation->file,
            'price' => $this->reservation->price,
            'hours' => $this->reservation->hours,
            'reservation_started' => $this->reservation->reservation_started,
            'reservation_startedTime' => $this->reservation->reservation_started_time,
            'reservation_code' => $this->reservation->reservation_code,
            'lawyer' => new AccountResourcePublic($this->reservation->lawyer),
            'reservationType' => new ReservationTypeShortResource($this->reservation->reservationType),
            'reservationImportance' => new ClientReservationsImportanceResource($this->reservation->importance),
            'created_at' => $this->reservation->created_at,
            'updated_at' => $this->reservation->updated_at,
        ];
    }
}
