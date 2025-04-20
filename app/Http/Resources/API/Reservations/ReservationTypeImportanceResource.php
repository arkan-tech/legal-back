<?php

namespace App\Http\Resources\API\Reservations;

use App\Models\Lawyer\Lawyer;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountResourcePublic;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Reservations\ReservationImportance;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Reservations\ReservationImportanceResource;

class ReservationTypeImportanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'reservation_importance_id' => $this->reservation_importance_id,
            'reservation_importance' => new ReservationImportanceResource($this->reservationImportance),
            'isYmtaz' => $this->isYmtaz,
            'lawyer' => new AccountResourcePublic($this->lawyer),
        ];
    }
}

