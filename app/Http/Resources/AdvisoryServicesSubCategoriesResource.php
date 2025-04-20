<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdvisoryServicesSubCategoryPricesResource;

class AdvisoryServicesSubCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'general_category' => new AdvisoryServicesGeneralCategoryResource($this->generalCategory),
            'levels' => AdvisoryServicesSubCategoryPricesResource::collection($this->levels),
        ];
    }
}
