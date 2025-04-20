<?php

namespace App\Http\Resources\API\Reservations;

use Carbon\Carbon;
use App\Http\Resources\AccountResourcePublic;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Http\Resources\API\Reservations\ReservationTypeShortResource;
use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerRegionsResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;

class ReservationRequestResource extends JsonResource
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
            'reservation_type' => new ReservationTypeShortResource($this->reservationType),
            'importance' => new ClientReservationsImportanceResource($this->importance),
            'account_id' => new AccountResourcePublic($this->account),
            'lawyer_id' => new AccountResourcePublic($this->lawyer),
            'price' => $this->price,
            'description' => $this->description,
            'file' => $this->file,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'day' => $this->day,
            'from' => $this->from,
            'to' => $this->to,
            'hours' => $this->hours,
            'status' => $this->status,
            'region_id' => new LawyerRegionsResource($this->region),
            'city_id' => new LawyerCitiesResource($this->city),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
