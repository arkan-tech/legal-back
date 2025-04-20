<?php

namespace App\Http\Resources\API\JudicialGuide;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerShortRegionsResource;
use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerShortCountriesResource;

class JudicialGuideResource extends JsonResource
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
            'image' => $this->image,
            'emails' => $this->emails()->pluck('email'),
            'numbers' => $this->numbers,
            'working_hours_from' => $this->working_hours_from,
            'working_hours_to' => $this->working_hours_to,
            'url' => $this->url,
            'sub_cateogry' => new JudicialGuideShortSubCategoryResource($this->subCategory),
            'about' => $this->about,
            'city' => new LawyerCitiesResource($this->city),
        ];
    }
}
