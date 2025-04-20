<?php

namespace App\Http\Resources;

use App\Http\Resources\PackageResource;
use App\Http\Resources\PackageResourceShort;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageSubscriptionResourceShort extends JsonResource
{
    public function toArray($request)
    {
        \Log::info(print_r($this->package, true));
        return [
            'id' => $this->id,
            'package' => new PackageResourceShort($this),
            'start_date' => $this->pivot->start_date,
            'end_date' => $this->pivot->end_date,
        ];
    }
}
