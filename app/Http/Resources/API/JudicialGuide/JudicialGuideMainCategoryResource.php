<?php

namespace App\Http\Resources\API\JudicialGuide;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerShortCountriesResource;

class JudicialGuideMainCategoryResource extends JsonResource
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
            'subCategories' => JudicialGuideSubCategoryResource::collection($this->subCategories),
            'country' => new LawyerShortCountriesResource($this->country),

        ];
    }
}
