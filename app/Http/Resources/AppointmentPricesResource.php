<?php

namespace App\Http\Resources;

use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentPricesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'lawyer' => new AccountResourcePublic($this->lawyer),
            'importance' => new ClientReservationsImportanceResource($this->importance),
            'is_hidden' => $this->is_hidden,
        ];
    }
}
