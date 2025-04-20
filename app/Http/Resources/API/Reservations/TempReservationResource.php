<?php

namespace App\Http\Resources\API\Reservations;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Reservations\ReservationTypeShortResource;

class TempReservationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reservation_type' => new ReservationTypeShortResource($this->reservationTypeImportance->reservationType),
            'reservation_importance' => new ReservationImportanceResource($this->reservationTypeImportance->reservationImportance),
            'reserverType' => $this->reserverType,
            'details' => $this->details,
            'created_at' => $this->created_at,
        ];
    }
}
