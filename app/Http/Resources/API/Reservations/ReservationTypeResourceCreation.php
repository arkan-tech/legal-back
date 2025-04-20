<?php

namespace App\Http\Resources\API\Reservations;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Reservations\ReservationTypeImportanceResourceShort;

class ReservationTypeResourceCreation extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
            'ymtazPrices' => ReservationTypeImportanceResourceShort::collection($this->typesImportance),
            'lawyerPrices' => $this->lawyerPrices,
            'is_activated' => $this->is_activated,
            'isHidden' => $this->isHidden
        ];
    }
}
