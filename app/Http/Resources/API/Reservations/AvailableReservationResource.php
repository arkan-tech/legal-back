<?php

namespace App\Http\Resources\API\Reservations;

use Illuminate\Http\Resources\Json\JsonResource;

class AvailableReservationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'isYmtaz' => $this->isYmtaz,
            // 'reservation_type_importance_id' => $this->reservation_type_importance_id,
            // 'reservationTypeImportance' => new ReservationTypeImportanceResource($this->reservationTypeImportance),
            'availableDateTime' => new AvailableReservationDateTimeResource($this->availableDateTime),
        ];
    }
}
