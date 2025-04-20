<?php

namespace App\Http\Resources\API\Lawyer;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Lawyer\LawyerServicesPriceResource;

class LawyerWithServicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'lawyer' => new LawyerDataResource($this->resource['lawyer']),
            'services' => LawyerServicesPriceResource::collection($this->resource['services']),
        ];
    }
}
