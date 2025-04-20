<?php

namespace App\Http\Resources\API\Lawyer\GeneralData\Regions;

use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Districts\LawyerDistrictsResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LawyerShortRegionsResource extends JsonResource
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
        ];
    }
}
