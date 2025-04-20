<?php

namespace App\Http\Resources\API\Lawyer;

use Carbon\Carbon;
use App\Models\Level;
use JsonSerializable;
use Illuminate\Http\Request;
use App\Models\Degree\Degree;
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

class LawyerShortDataResource extends JsonResource
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
        if (!is_null($client)) {
            $fav_lawyers = ClientsFavoritesLawyers::where('client_id', $client->id)->pluck('lawyer_id')->toArray();
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

        $nextLevel = Level::where('level_number', $this->level->level_number + 1)->first();
        // dd('stoped her');

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
            'active' => $this->activate_email_otp ? 0 : 1,
            'confirmationType' => $this->confirmationType,
            'languages' => LawyerLanguageResource::collection($this->languages),
            "streamio_id" => $this->streamio_id,
            'streamio_token' => $this->streamio_token,
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
