<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Models\WorkingHours\WorkingHours;
use App\Http\Resources\PermissionResource;
use App\Models\Packages\PackageSubscription;
use Illuminate\Http\Resources\Json\JsonResource;
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

class AccountResourceShort extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $nextLevel = Level::where('level_number', $this->clientGamification()->level->level_number + 1)->first();
        //            $fav_lawyers = FavouriteLawyers::where('lawyer_id', $lawyer->id)->pluck('fav_lawyer_id')->toArray();

        $fav_lawyers = [];
        if (
            !empty($this->profile_photo) || !is_null($this->profile_photo)
        ) {
            $image = asset('uploads/account/profile_photo/' . str_replace('\\', '/', $this->profile_photo));
        } elseif ($this->gender == "Male") {

            $image = asset('Male.png');
        } elseif ($this->gender == "Female") {
            $image = asset('Female.png');
        } else {
            $image = asset('uploads/person.png');
        }
        $isLawyer = $this->account_type == "lawyer";
        $client = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_code' => $this->phone_code,
            'type' => intval($this->type),
            'image' => $image,
            'nationality' => new LawyerNationalitiesResource($this->nationality),
            'country' => new LawyerShortCountriesResource($this->country),
            'region' => new LawyerShortRegionsResource($this->region),
            'city' => new LawyerCitiesResource($this->city),
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'gender' => $this->gender,
            'currentLevel' => $this->clientGamification()->level->level_number,
            'currentRank' => [
                'id' => $this->clientGamification()->rank->id,
                'name' => $this->clientGamification()->rank->name,
                'border_color' => $this->clientGamification()->rank->border_color,
                'image' => $this->clientGamification()->rank->image
            ],
            'lastSeen' => Carbon::parse($this->last_seen)->toISOString(),
            'account_type' => $this->account_type,
            'subscribed' => $this->isUserSubscribed($this)

        ];
        if ($isLawyer) {
            $splittedName = explode(" ", $this->name);

            $name = join(' ', [$splittedName[0], $splittedName[1], count($splittedName) == 4 ? $splittedName[3] : $splittedName[2]]);
            $currentDate = Carbon::now();
            $subscription = PackageSubscription::with('package.permissions')
                ->where('account_id', $this->id)
                ->where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->latest()
                ->first();
            $lawyerData = [
                'name' => $name,
                'about' => $this->lawyerDetails->about,
                'accurate_specialty' => is_null($this->lawyerDetails->accurate_specialty) ? null : new LawyerAccurateSpecialtyResource($this->lawyerDetails->AccurateSpecialty),
                'general_specialty' => is_null($this->lawyerDetails->general_specialty) ? null : new LawyerGeneralSpecialtyResource($this->lawyerDetails->GeneralSpecialty),
                'degree' => is_null($this->lawyerDetails->degree) ? null : new LawyerDegreesResource($this->lawyerDetails->degreeRel),
                'functional_cases' => is_null($this->lawyerDetails->functional_cases) ? null : new LawyerFunctionalCasesResource($this->lawyerDetails->functional_cases_rel),
                'company_name' => $this->lawyerDetails->company_name,
                'is_favorite' => in_array($this->id, $fav_lawyers) ? 1 : 0,
                'special' => $this->lawyerDetails->is_special,
                'logo' => $this->lawyerDetails->logo,
                'sections' => LawyerSectionResource::collection($this->lawyerDetails->SectionsRel),
                'permissions' => $subscription ? PermissionResource::collection($subscription->package->permissions) : [],
                'hasBadge' => $subscription ? ($subscription->package->permissions->contains('id', 1) ? 'blue' : ($subscription->package->permissions->contains('id', 7) ? 'gold' : null)) : null,
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
            ->where(function ($query) use ($currentDate) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $currentDate);
            })
            ->orderBy('start_date', 'desc')
            ->first();

        // Ensure this subscription belongs to the current account
        return !is_null($latestSubscription);
    }
}
