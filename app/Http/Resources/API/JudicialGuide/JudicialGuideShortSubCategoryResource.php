<?php

namespace App\Http\Resources\API\JudicialGuide;

use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerShortCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerShortRegionsResource;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use Illuminate\Http\Resources\Json\JsonResource;

class JudicialGuideShortSubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'locationUrl' => $this->locationUrl,
            'address' => $this->address
        ];
    }
}
