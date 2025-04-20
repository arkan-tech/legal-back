<?php

namespace App\Http\Resources\API\Lawyer\GeneralData\Cities;

use App\Http\Resources\API\Lawyer\GeneralData\Districts\LawyerDistrictsResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerRegionsResource;
use App\Models\Regions\Regions;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LawyerCitiesResource extends JsonResource
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
            'id'=>$this->id,
            'title' => $this->title,
//            'districts'=>LawyerDistrictsResource::collection($this->districts)
        ];
    }
}
