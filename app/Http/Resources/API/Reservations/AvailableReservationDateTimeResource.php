<?php

namespace App\Http\Resources\API\Reservations;

use Illuminate\Http\Resources\Json\JsonResource;

class AvailableReservationDateTimeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reservation_id' => $this->reservation_id,
            'day' => $this->day,
            'from' => $this->from,
            'to' => $this->to,
        ];
    }
}
