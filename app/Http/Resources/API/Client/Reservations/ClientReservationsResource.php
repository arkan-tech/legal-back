<?php

namespace App\Http\Resources\API\Client\Reservations;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationTypeResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ClientReservationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {

        $client_advisory_services = new AdvisoryServicesReservationResource(ClientAdvisoryServicesReservations::where('id', $this->client_advisory_services_reservation_id)->first());
        return [
            'id' => $this->id,
            'day' => $this->day,
            'month' => $this->month,
            'year' => $this->year,
            'fullDate' => $this->date,
            'time_clock' => $this->time_clock,
            'time_minute' => $this->time_minute,
            'fullTime' => $this->fullTime,
            'notes' => $this->notes,
            'reservation_status' => $this->reservation_status,
            'reservation_with_ymtaz' => $this->reservation_with_ymtaz,
            'price' => $this->price,
            'client_advisory_services_reservation' => $client_advisory_services,
            'type' => new ClientReservationTypeResource($this->typeRel),
            'importance' => new ClientReservationsImportanceResource($this->importanceRel),
            'lawyer'=>new LawyerDataResource($this->lawyer),
        ];
    }
}
