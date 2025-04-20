<?php

namespace App\Http\Resources\API\AdvisoryServices;

use App\Http\Resources\API\DigitalGuide\Categories\DigitalGuideCategoriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Section\LawyerSectionResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class AdvisoryServicesResource extends JsonResource
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
            'title' => $this->payment_category_type->name,
            'description' => $this->description,
            'instructions' => $this->instructions,
            'phone' => $this->phone,
            'need_appointment' => $this->need_appointment,
            'image' => $this->image,
            'payment_category' => new AdvisoryServicesPaymentCategoryResource($this->payment_category),
        ];
    }
}
