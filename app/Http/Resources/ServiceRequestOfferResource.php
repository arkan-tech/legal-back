<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountResourcePublic;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Resources\AdvisoryServicesReservationFileResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;

class ServiceRequestOfferResource extends JsonResource
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
            'account' => new AccountResource($this->account),
            'service' => new ServicesResource($this->service),
            'priority' => new ClientReservationsImportanceResource($this->importance),
            'description' => $this->description,
            'files' => AdvisoryServicesReservationFileResource::collection($this->files()->where('is_reply', false)->get()),
            'price' => $this->price,
            'lawyer' => new AccountResourcePublic($this->lawyer),
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
