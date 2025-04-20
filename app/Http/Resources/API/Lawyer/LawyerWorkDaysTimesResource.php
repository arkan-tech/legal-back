<?php

namespace App\Http\Resources\API\Lawyer;

use App\Http\Resources\API\Services\ServicesResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LawyerWorkDaysTimesResource extends JsonResource
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
            'time_from'=>$this->time_from,
            'time_to'=>$this->time_to,
        ];
    }
}
