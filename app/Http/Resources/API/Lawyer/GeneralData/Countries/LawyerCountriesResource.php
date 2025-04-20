<?php

namespace App\Http\Resources\API\Lawyer\GeneralData\Countries;

use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerRegionsResource;
use App\Models\Regions\Regions;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LawyerCountriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_code' => $this->phone_code,
            'regions' => LawyerRegionsResource::collection($this->regions)
        ];
    }
}
