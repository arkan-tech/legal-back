<?php

namespace App\Http\Resources\API\Reservations;

use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Reservations\ReservationImportance;
use App\Http\Resources\API\Reservations\ReservationImportanceResource;

class ReservationTypeImportanceResourceShort extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'isHidden' => $this->isHidden,
            'level' => [
                "id" => $this->reservationImportance->id,
                "name" => $this->reservationImportance->name,

            ]
        ];
    }
}
