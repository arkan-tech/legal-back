<?php

namespace App\Http\Resources\API\AdvisoryCommittees;

use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Degrees\LawyerDegreesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Districts\LawyerDistrictsResource;
use App\Http\Resources\API\Lawyer\GeneralData\FunctionalCases\LawyerFunctionalCasesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerRegionsResource;
use App\Http\Resources\API\Lawyer\GeneralData\Section\LawyerSectionResource;
use App\Http\Resources\API\Lawyer\GeneralData\Specialty\LawyerAccurateSpecialtyResource;
use App\Http\Resources\API\Lawyer\GeneralData\Specialty\LawyerGeneralSpecialtyResource;
use App\Models\Client\ClientsFavoritesLawyers;
use App\Models\Degree\Degree;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LawyerAdvisoryShortDataResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'about' => $this->about,
            'birthday' => $this->birthday,
            'photo' => $this->photo,
            'office_request_status' => $this->office_request_status,
            'special' => $this->special,
            'sections' => LawyerSectionResource::collection($this->SectionsRel),
        ];
    }
}
