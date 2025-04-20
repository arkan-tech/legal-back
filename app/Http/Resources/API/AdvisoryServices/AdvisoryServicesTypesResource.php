<?php

namespace App\Http\Resources\API\AdvisoryServices;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class AdvisoryServicesTypesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'ymtaz_price' => $this->ymtaz_price,
            'advisory_service_prices' => AdvisoryServicesPricesResource::collection($this->advisory_services_prices)

        ];
    }
}

