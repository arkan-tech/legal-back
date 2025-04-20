<?php

namespace App\Http\Resources;

use App\Http\Resources\API\Services\ServicesResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdvisoryServiceSubCategoryResource;
use App\Http\Resources\AdvisoryServicesSubCategoriesResource;
use App\Http\Resources\API\Services\ServiceSubCategoryResource;
use App\Http\Resources\API\Reservations\ReservationTypeResource;

class EliteServiceRequestProductOfferResource extends JsonResource
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
            'advisory_service_sub' => new AdvisoryServicesSubCategoriesResource($this->advisoryServiceSub),
            'advisory_service_sub_price' => $this->advisory_service_sub_price,
            'advisory_service_date' => $this->advisory_service_date,
            'advisory_service_from_time' => $this->advisory_service_from_time,
            'advisory_service_to_time' => $this->advisory_service_to_time,
            'service_sub' => new ServicesResource($this->serviceSub),
            'service_sub_price' => $this->service_sub_price,
            'reservation_type' => new ReservationTypeResource($this->reservationType),
            'reservation_price' => $this->reservation_price,
            'reservation_date' => $this->reservation_date,
            'reservation_from_time' => $this->reservation_from_time,
            'reservation_to_time' => $this->reservation_to_time,
            'reservation_latitude' => $this->reservation_latitude,
            'reservation_longitude' => $this->reservation_longitude,
            'advisory_service_sub_price_counter' => $this->advisory_service_sub_price_counter,
            'advisory_service_date_counter' => $this->advisory_service_date_counter,
            'advisory_service_from_time_counter' => $this->advisory_service_from_time_counter,
            'advisory_service_to_time_counter' => $this->advisory_service_to_time_counter,
            'service_sub_price_counter' => $this->service_sub_price_counter,
            'reservation_price_counter' => $this->reservation_price_counter,
            'reservation_date_counter' => $this->reservation_date_counter,
            'reservation_from_time_counter' => $this->reservation_from_time_counter,
            'reservation_to_time_counter' => $this->reservation_to_time_counter,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
