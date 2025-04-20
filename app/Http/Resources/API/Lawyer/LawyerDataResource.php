<?php

namespace App\Http\Resources\API\Lawyer;

use Carbon\Carbon;
use App\Models\Level;
use JsonSerializable;
use Illuminate\Http\Request;
use App\Models\Degree\Degree;
use App\Models\Service\Service;
use App\Models\FavouriteLawyers;
use App\Models\Lawyer\LawyerRates;
use App\Models\Lawyer\LawyerWorkDays;
use LevelUp\Experience\Models\Activity;
use Illuminate\Contracts\Support\Arrayable;
use App\Models\Client\ClientsFavoritesLawyers;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Lawyer\LawyerLanguageResource;
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

class LawyerDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        /*
         * if office_request_status == 0 ['work_times' , 'services'] => Null because related of electronic office
         * */
        $client = auth()->guard('api_client')->user();
        $lawyer = auth()->guard('api_client')->user();
        if (!is_null($client)) {
            $fav_lawyers = FavouriteLawyers::where('service_user_id', $client->id)->pluck('fav_lawyer_id')->toArray();

        } else if (!is_null($lawyer)) {
            $fav_lawyers = FavouriteLawyers::where('lawyer_id', $lawyer->id)->pluck('fav_lawyer_id')->toArray();

        } else {
            $fav_lawyers = [];

        }
        $lawyerId = $this->id;
        $lawyer_rates = LawyerRates::where('lawyer_id', $this->id)->pluck('rate')->toArray();
        // $lawyerServicesPrices = Service::whereHas('lawyerPrices', function ($query) use ($lawyerId) {
        //     $query->where('lawyer_id', $lawyerId);
        // })->with([
        //             'lawyerPrices' => function ($query) use ($lawyerId) {
        //                 $query->where('lawyer_id', $lawyerId)
        //                     ->with('importance');
        //             }
        //         ])->get();
        $rates_avg = CalculateRateAvg($lawyer_rates);
        $nextLevel = Level::where('level_number', $this->level->level_number + 1)->first();
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'third_name' => $this->third_name,
            'fourth_name' => $this->fourth_name,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => str_replace($this->phone_code, '', $this->phone),
            'phone_code' => $this->phone_code,
            'about' => $this->about,
            'accurate_specialty' => new LawyerAccurateSpecialtyResource($this->AccurateSpecialty),
            'general_specialty' => new LawyerGeneralSpecialtyResource($this->GeneralSpecialty),
            'degree' => new LawyerDegreesResource($this->degreeRel),
            'other_degree' => !is_null($this->other_degree) ? $this->other_degree->title : null,
            'gender' => $this->gender,
            'day' => $this->day,
            'month' => $this->month,
            'year' => $this->year,
            'birthday' => $this->birthday,
            'nationality' => !is_null($this->nationality_rel) ? new LawyerNationalitiesResource($this->nationality_rel) : null,
            'country' => !is_null($this->country) ? new LawyerShortCountriesResource($this->country) : null,
            'region' => !is_null($this->region_rel) ? new LawyerShortRegionsResource($this->region_rel) : null,
            'city' => !is_null($this->city_rel) ? new LawyerCitiesResource($this->city_rel) : null,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'type' => intval($this->type) != 0 ? intval($this->type) : 1,
            'identity_type' => $this->identity_type,
            'nat_id' => $this->nat_id,
            'functional_cases' => new LawyerFunctionalCasesResource($this->functional_cases_rel),
            'company_lisences_no' => $this->company_lisences_no,
            'company_name' => $this->company_name,
            'office_request_status' => $this->office_request_status,
            'office_request_from' => $this->office_request_from,
            'office_request_to' => $this->office_request_to,
            'is_favorite' => in_array($this->id, $fav_lawyers) ? 1 : 0,
            'special' => $this->special,
            'logo' => $this->logo,
            'id_file' => $this->id_file,
            'cv' => $this->cv,
            'degree_certificate' => $this->degree_certificate,
            'photo' => $this->photo,
            'company_lisences_file' => $this->company_lisences_file,
            'accept_rules' => intval($this->accept_rules),
            'sections' => LawyerSectionResource::collection($this->SectionsRel),
            // 'services' => LawyerServicesPriceResource::collection($lawyerServicesPrices),
            'work_times' => LawyerWorkDaysResource::collection($this->WorkTimes),
            'rates_count' => count($lawyer_rates) != 0 ? count($lawyer_rates) : null,
            'rates_avg' => $rates_avg,
            'digital_guide_subscription' => $this->digital_guide_subscription,
            'digital_guide_subscription_payment_status' => $this->digital_guide_subscription_payment_status,
            'accepted' => $this->accepted,
            'active' => $this->activate_email_otp ? 0 : 1,
            'languages' => LawyerLanguageResource::collection($this->languages),
            'createdAt' => $this->created_at,
            'daysStreak' => $this->streak,
            'points' => $this->paymentPoints(),
            'xp' => $this->experience,
            'currentLevel' => $this->level->level_number,
            'currentRank' => [
                'id' => $this->rank->id,
                'name' => $this->rank->name,
                'border_color' => $this->rank->border_color,
                'image' => $this->rank->image
            ],
            'xpUntilNextLevel' => is_null($nextLevel) ? 0 : $nextLevel->required_experience,
            'referralCode' => $this->referralCode->referral_code,
            'lastSeen' => Carbon::parse($this->last_seen)->toISOString()
        ];
    }
}
