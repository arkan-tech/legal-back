<?php

namespace App\Http\Resources\API\Lawyer;

use App\Http\Resources\API\Services\ServicesResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LawyerWorkDaysResource extends JsonResource
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
            'day_name' => $this->day_name,
            'times'=>LawyerWorkDaysTimesResource::collection($this->times)
        ];
    }
}
