<?php

namespace App\Http\Resources\API\Client\Reservations\Requirements;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientReservationTypeResource extends JsonResource
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
            'title'=>$this->title,
        ];
    }
}
