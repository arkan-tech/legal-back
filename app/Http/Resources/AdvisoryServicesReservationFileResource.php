<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvisoryServicesReservationFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'file' => $this->file,
            'is_voice' => $this->is_voice,
            'is_reply' => $this->is_reply,
        ];
    }
}
