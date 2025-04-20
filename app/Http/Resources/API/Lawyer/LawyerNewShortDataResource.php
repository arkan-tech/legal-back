<?php

namespace App\Http\Resources\API\Lawyer;

use JsonSerializable;
use Illuminate\Http\Request;
use App\Models\Degree\Degree;
use App\Models\FavouriteLawyers;
use App\Models\Lawyer\LawyerRates;
use Illuminate\Contracts\Support\Arrayable;
use App\Models\Client\ClientsFavoritesLawyers;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Degrees\LawyerDegreesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerRegionsResource;
use App\Http\Resources\API\Lawyer\GeneralData\Section\LawyerSectionResource;
use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Districts\LawyerDistrictsResource;
use App\Http\Resources\API\Lawyer\GeneralData\Specialty\LawyerGeneralSpecialtyResource;
use App\Http\Resources\API\Lawyer\GeneralData\Specialty\LawyerAccurateSpecialtyResource;
use App\Http\Resources\API\Lawyer\GeneralData\FunctionalCases\LawyerFunctionalCasesResource;

class LawyerNewShortDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $client = auth()->guard('api_client')->user();
        $lawyer = auth()->guard('api_client')->user();

        if (!is_null($client)) {
            $fav_lawyers = FavouriteLawyers::where('service_user_id', $client->id)->pluck('fav_lawyer_id')->toArray();
        } else if (!is_null($lawyer)) {
            $fav_lawyers = FavouriteLawyers::where('lawyer_id', $lawyer->id)->pluck('fav_lawyer_id')->toArray();

        } else {
            $fav_lawyers = [];
        }
        $lawyer_rates = LawyerRates::where('lawyer_id', $this->id)->pluck('rate')->toArray();
        $rates_avg = count($lawyer_rates) != 0 ? array_sum($lawyer_rates) / count($lawyer_rates) : null;
        if ($rates_avg == null) {
            $rates_avg = null;
        } else {
            $rates_avg = $rates_avg >= 5 ? 4 : $rates_avg;
        }
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'third_name' => $this->third_name,
            'fourth_name' => $this->fourth_name,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'about' => $this->about,
            'birthday' => $this->birthday,
            'photo' => $this->photo,
            'is_favorite' => in_array($this->id, $fav_lawyers) ? 1 : 0,
            'office_request_status' => $this->office_request_status,
            'special' => $this->special,
            'sections' => LawyerSectionResource::collection($this->SectionsRel),
            'rates_count' => count($lawyer_rates) != 0 ? count($lawyer_rates) : null,
            'rates_avg' => $rates_avg,
            'token' => $this->token,
            'accepted' => $this->accepted,
        ];
    }
}
