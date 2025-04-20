<?php

namespace App\Http\Resources\API\AdvisoryServices;

use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvisoryServicesAvailableDatesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'date'=>$this->date,
            'times'=>AdvisoryServicesAvailableDatesTimesResource::collection($this->available_times)
        ];
    }
}
