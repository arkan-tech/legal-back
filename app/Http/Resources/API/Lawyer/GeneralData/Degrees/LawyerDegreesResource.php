<?php

namespace App\Http\Resources\API\Lawyer\GeneralData\Degrees;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LawyerDegreesResource extends JsonResource
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
            'isSpecial' => $this->isSpecial,
            'need_certificate' => $this->need_certificate,
        ];
    }
}
