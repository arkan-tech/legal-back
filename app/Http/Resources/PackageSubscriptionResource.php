<?php

namespace App\Http\Resources;

use App\Http\Resources\PackageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageSubscriptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'package' => new PackageResource($this->package),
            'remaining_services' => $this->package->number_of_services - $this->consumed_services,
            'remaining_advisory_services' => $this->package->number_of_advisory_services - $this->consumed_advisory_services,
            'remaining_reservations' => $this->package->number_of_reservations - $this->consumed_reservations,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];
    }
}
