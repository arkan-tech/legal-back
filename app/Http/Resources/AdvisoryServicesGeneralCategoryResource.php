<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesPaymentCategoryTypeResource;

class AdvisoryServicesGeneralCategoryResource extends JsonResource
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
            'payment_category_type' => new AdvisoryServicesPaymentCategoryTypeResource($this->paymentCategoryType),
        ];
    }
}
