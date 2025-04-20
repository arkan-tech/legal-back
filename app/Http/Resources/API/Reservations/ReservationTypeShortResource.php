<?php

namespace App\Http\Resources\API\Reservations;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationTypeShortResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
        ];
    }
}
