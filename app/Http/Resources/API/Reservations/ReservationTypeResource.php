<?php

namespace App\Http\Resources\API\Reservations;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
            'typesImportance' => ReservationTypeImportanceResource::collection($this->typesImportance)
        ];
    }
}
