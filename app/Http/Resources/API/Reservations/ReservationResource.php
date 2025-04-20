<?php

namespace App\Http\Resources\API\Reservations;

use Carbon\Carbon;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountResourcePublic;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerBasicDataResource;
use App\Http\Resources\API\Reservations\ReservationTypeShortResource;
use App\Http\Resources\API\Reservations\ReservationImportanceResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;

class ReservationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'account' => new AccountResourcePublic($this->account),
            'description' => $this->description,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'date' => $this->day,
            'from' => $this->from,
            'to' => $this->to,
            'country_id' => $this->country_id,
            'region_id' => $this->region_id,
            'file' => $this->file,
            'price' => $this->price,
            'hours' => $this->hours,
            'reservation_started' => $this->reservation_started,
            'reservation_startedTime' => $this->reservation_started_time,
            'lawyer' => new AccountResourcePublic($this->lawyer),
            'reservationType' => new ReservationTypeShortResource($this->reservationType),
            'reservationImportance' => new ClientReservationsImportanceResource($this->importance),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
