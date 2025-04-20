<?php

namespace App\Http\Resources\API\AdvisoryServices;

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
            'title' => $this->title,
            'description' => $this->description,
            'instructions' => $this->instructions,
            'price' => $this->price,
            'phone' => $this->phone,
            'need_appointment' => $this->need_appointment,
            'image' => $this->image,
            'available_dates'=>AdvisoryServicesAvailableDatesResource::collection($this->available_dates),
        ];
    }
}
