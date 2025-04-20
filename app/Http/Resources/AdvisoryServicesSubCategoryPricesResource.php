<?php

namespace App\Http\Resources;

use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvisoryServicesSubCategoryPricesResource extends JsonResource
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
            'duration' => $this->duration,
            'level' => new ClientReservationsImportanceResource($this->importance),
            'price' => $this->price,
        ];
    }
}
