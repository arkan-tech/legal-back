<?php

namespace App\Http\Resources\API\Lawyer;

use App\Models\FavouriteLawyers;
use JsonSerializable;
use Illuminate\Http\Request;
use App\Models\Degree\Degree;
use App\Models\Service\Service;
use App\Models\Lawyer\LawyerRates;
use App\Models\Lawyer\LawyerWorkDays;
use Illuminate\Contracts\Support\Arrayable;
use App\Models\Client\ClientsFavoritesLawyers;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Degrees\LawyerDegreesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerRegionsResource;
use App\Http\Resources\API\Lawyer\GeneralData\Section\LawyerSectionResource;
use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Districts\LawyerDistrictsResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerShortRegionsResource;
use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerShortCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Specialty\LawyerGeneralSpecialtyResource;
use App\Http\Resources\API\Lawyer\GeneralData\Nationalities\LawyerNationalitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Specialty\LawyerAccurateSpecialtyResource;
use App\Http\Resources\API\Lawyer\GeneralData\FunctionalCases\LawyerFunctionalCasesResource;

class LawyerBasicDataResource extends JsonResource
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
            'phone' => str_replace($this->phone_code, '', $this->phone),
            'phone_code' => $this->phone_code,
            'special' => $this->special,
            'logo' => $this->logo,
            'photo' => $this->photo,
        ];
    }
}
