<?php

namespace App\Http\Resources\API\Services;

use App\Http\Resources\API\RequestLevel\RequestLevelResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ServiceYmtazLevelPricesResource extends JsonResource
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
            'level' => new RequestLevelResource($this->level),
            'price' => $this->price,
            'duration' => $this->duration,
            'isHidden' => $this->isHidden
        ];
    }
}
