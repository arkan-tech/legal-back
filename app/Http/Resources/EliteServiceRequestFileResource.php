<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EliteServiceRequestFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'elite_service_request_id' => $this->elite_service_request_id,
            'advisory_services_reservations_id' => $this->advisory_services_reservations_id,
            'services_reservations_id' => $this->services_reservations_id,
            'reservations_id' => $this->reservations_id,
            'file' => $this->file,
            'is_voice' => $this->is_voice,
            'is_reply' => $this->is_reply,
        ];
    }
}
