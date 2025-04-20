<?php

namespace App\Http\Resources\API\AdvisoryServices;

use App\Models\AdvisoryServices\AdvisoryServicesPrices;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class AdvisoryServicesPricesResource extends JsonResource
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
            'id' => $this->importance->id,
            'title' => $this->importance->title,
            'advisory_service_id' => $this->advisory_service_id,
            'request_level' => $this->client_reservations_importance_id,
            'price' => $this->price
        ];
    }
}
