<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Models\AccountBankInfo;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkingHours\WorkingHours;
use App\Http\Resources\PermissionResource;
use App\Models\Packages\PackageSubscription;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PackageSubscriptionResourceShort;
use App\Http\Resources\API\Lawyer\LawyerLanguageResource;
use App\Http\Resources\API\Lawyer\LawyerWorkDaysResource;
use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Degrees\LawyerDegreesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Section\LawyerSectionResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerShortRegionsResource;
use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerShortCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Specialty\LawyerGeneralSpecialtyResource;
use App\Http\Resources\API\Lawyer\GeneralData\Nationalities\LawyerNationalitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Specialty\LawyerAccurateSpecialtyResource;
use App\Http\Resources\API\Lawyer\GeneralData\FunctionalCases\LawyerFunctionalCasesResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $gamification = $this->clientGamification();

        $nextLevel = null;

        if ($gamification && $gamification->level) {
            $nextLevel = Level::where('level_number', $gamification->level->level_number + 1)->first();
        }
        $fav_lawyers = [];

        $isLawyer = $this->account_type == "lawyer";
        $isSubscribed = $this->isUserSubscribed($this);
        $client = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_code' => $this->phone_code,
            'type' => intval($this->type),
            'image' => $this->profile_photo_url,
            'nationality' => new LawyerNationalitiesResource($this->nationality),
            'country' => new LawyerShortCountriesResource($this->country),
            'region' => new LawyerShortRegionsResource($this->region),
            'city' => new LawyerCitiesResource($this->city),
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'gender' => $this->gender,
            'token' => $this->token,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            "streamio_id" => $this->streamio_id,
            'streamio_token' => $this->streamio_token,
            'daysStreak' => optional($this->clientGamification())->streak ?? 0,
            'points' => optional($this->clientGamification())->paymentPoints() ?? 0,
            'xp' => optional($this->clientGamification())->experience ?? 0,
            'currentLevel' => optional(optional($this->clientGamification())->level)->level_number ?? 0,
            'currentRank' => [
                'id' => optional(optional($this->clientGamification())->rank)->id ?? 0,
                'name' => optional(optional($this->clientGamification())->rank)->name ?? '',
                'border_color' => optional(optional($this->clientGamification())->rank)->border_color ?? '#ccc',
                'image' => optional(optional($this->clientGamification())->rank)->image ?? null,
            ],

            'xpUntilNextLevel' => is_null($nextLevel) ? 0 : $nextLevel->required_experience,
            'referralCode' => $this->referralCode ? $this->referralCode->referral_code : null,
            'lastSeen' => !is_null($this->last_seen) ? Carbon::parse($this->last_seen)->toISOString() : null,
            'email_confirmation' => $this->email_confirmation,
            'phone_confirmation' => $this->phone_confirmation,
            'profile_complete' => $this->profile_complete,
            'account_type' => $this->account_type,
            'subscribed' => $isSubscribed,
            'subscription' => $isSubscribed ? new PackageSubscriptionResourceShort($this->currentSubscription($this)) : null,

        ];
        if ($isLawyer) {
            $workingHours = WorkingHours::where('account_details_id', $this->lawyerDetails->id)->get();
            $workingSchedule = new WorkingSchedule;
            foreach ($workingHours as $workingHour) {
                $workingSchedule->addTimeSlot($workingHour->service, $workingHour->dayOfWeek, $workingHour->from, $workingHour->to);
            }
            $workingSchedule = $workingSchedule->getSchedule();
            $splittedName = explode(" ", $this->name);
            $birthday = $this->lawyerDetails->year . '-' . $this->lawyerDetails->month . '-' . $this->lawyerDetails->day;
            $birthdayDateTime = is_null($this->lawyerDetails->year) || is_null($this->lawyerDetails->month) || is_null($this->lawyerDetails->day) ? null : Carbon::parse($birthday);
            $name = join(' ', [$splittedName[0], $splittedName[1], count($splittedName) == 4 ? $splittedName[3] : $splittedName[2]]);
            $currentDate = Carbon::now();
            $subscription = PackageSubscription::with('package.permissions')
                ->where('account_id', $this->id)
                ->where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->latest()
                ->first();
            $lawyerData = [
                'first_name' => $splittedName[0],
                'second_name' => $splittedName[1],
                'third_name' => count($splittedName) == 4 ? $splittedName[2] : null,
                'fourth_name' => count($splittedName) == 4 ? $splittedName[3] : $splittedName[2],
                'name' => $name,
                'about' => $this->lawyerDetails->about,
                'accurate_specialty' => is_null($this->lawyerDetails->accurate_specialty) ? null : new LawyerAccurateSpecialtyResource($this->lawyerDetails->AccurateSpecialty),
                'general_specialty' => is_null($this->lawyerDetails->general_specialty) ? null : new LawyerGeneralSpecialtyResource($this->lawyerDetails->GeneralSpecialty),
                'degree' => is_null($this->lawyerDetails->degree) ? null : new LawyerDegreesResource($this->lawyerDetails->degreeRel),
                // 'other_degree' => $this->lawyerDetails->other_degree,
                'day' => $this->lawyerDetails->day,
                'month' => $this->lawyerDetails->month,
                'year' => $this->lawyerDetails->year,
                'birth_date' => $birthdayDateTime,
                'identity_type' => $this->lawyerDetails->identity_type,
                'national_id' => $this->lawyerDetails->national_id,
                'functional_cases' => is_null($this->lawyerDetails->functional_cases) ? null : new LawyerFunctionalCasesResource($this->lawyerDetails->functional_cases_rel),
                'company_name' => $this->lawyerDetails->company_name,
                'is_favorite' => in_array($this->id, $fav_lawyers) ? 1 : 0,
                'special' => $this->lawyerDetails->is_special,
                'logo' => $this->lawyerDetails->logo,
                'id_file' => $this->lawyerDetails->national_id_image,
                'cv' => $this->lawyerDetails->cv_file,
                'degree_certificate' => $this->lawyerDetails->degree_certificate,
                'company_licences_no' => $this->lawyerDetails->licences_no,
                'company_licenses_file' => $this->lawyerDetails->company_licenses_file,
                'sections' => LawyerSectionResource::collection($this->lawyerDetails->SectionsRel),
                'work_times' => $workingSchedule,
                'languages' => LawyerLanguageResource::collection($this->lawyerDetails->languages),
                'permissions' => $subscription ? PermissionResource::collection($subscription->package->permissions) : [],
                'hasBadge' => $subscription ? ($subscription->package->permissions->contains('id', 7) ? 'gold' : ($subscription->package->permissions->contains('id', 1) ? 'blue' : null)) : null,
                'experiences' => AccountExperienceResource::collection($this->experiences),
                'bankInfo' => AccountBankInfo::where('account_id', $this->id)->exists() ? true : false,
                'is_pricing_committee' => $this->pricingCommittee()->exists(),
            ];
            $client = array_merge($client, $lawyerData);
        }

        return $client;
    }
    private function isUserSubscribed($user): bool
    {
        $currentDate = Carbon::now();
        $latestSubscription = $user->subscriptions()
            ->where('start_date', '<=', $currentDate)
            ->where('transaction_complete', 1)
            ->where(function ($query) use ($currentDate) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $currentDate);
            })
            ->orderBy('start_date', 'desc')
            ->first();

        // Ensure this subscription belongs to the current account
        return !is_null($latestSubscription);
    }

    private function currentSubscription($user)
    {
        $currentDate = Carbon::now();
        $sub = $user->subscriptions()
            ->where('start_date', '<=', $currentDate)
            ->where('transaction_complete', 1)
            ->where(function ($query) use ($currentDate) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $currentDate);
            })
            ->orderBy('start_date', 'desc');
        \Illuminate\Support\Facades\Log::info(print_r($sub->get(), true));

        return $sub->first();
    }
}
class WorkingSchedule
{
    protected $services = [];

    public function addTimeSlot($service, $dayOfWeek, $from, $to)
    {
        if (!isset($this->services[$service])) {
            $this->services[$service] = [
                'service' => $service,
                'days' => [],
            ];
        }

        if (!isset($this->services[$service]['days'][$dayOfWeek])) {
            $this->services[$service]['days'][$dayOfWeek] = [
                'dayOfWeek' => $dayOfWeek,
                'timeSlots' => [],
            ];
        }

        $this->services[$service]['days'][$dayOfWeek]['timeSlots'][] = ['from' => $from, 'to' => $to];
    }


    public function getSchedule()
    {
        $schedule = [];

        foreach ($this->services as $service) {
            $serviceObj = [
                'service' => $service['service'],
                'days' => array_values($service['days']), // Reindexing days array
            ];

            $schedule[] = $serviceObj;
        }

        return $schedule;
    }
}