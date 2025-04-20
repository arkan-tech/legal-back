<?php

namespace App\Http\Resources\API\DigitalGuide\Packages;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class SubscribeDigitalGuidePackagesResource extends JsonResource
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
            'id'=> $this->id,
            'title'=> $this->title,
            'intro'=> $this->intro,
            'price'=> $this->price,
            'period'=> $this->period,
            'rules'=> $this->rules,
            'payment_url' => $this->payment_url
        ];
    }
}
