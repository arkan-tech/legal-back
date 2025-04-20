<?php

namespace App\Http\Resources\API\Client;

use Carbon\Carbon;
use App\Models\Level;
use JsonSerializable;
use Illuminate\Http\Request;
use LevelUp\Experience\Models\Activity;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerShortRegionsResource;
use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerShortCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Nationalities\LawyerNationalitiesResource;

class ClientDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $nextLevel = Level::where('level_number', $this->level->level_number + 1)->first();

        return [
            'id' => $this->id,
            'name' => $this->myname,
            'phone_code' => $this->phone_code,
            'mobile' => str_replace($this->phone_code, '', $this->mobil),
            'type' => intval($this->type),
            'email' => $this->email,
            'image' => !empty($this->image) || !is_null($this->image) ? asset('uploads/client/profile/image/' . str_replace('\\', '/', $this->image)) : asset('uploads/person.png'),
            'nationality' => !is_null($this->nationality) ? new LawyerNationalitiesResource($this->nationality) : null,
            'country' => !is_null($this->country) ? new LawyerShortCountriesResource($this->country) : null,
            'region' => !is_null($this->region) ? new LawyerShortRegionsResource($this->region) : null,
            'city' => !is_null($this->city) ? new LawyerCitiesResource($this->city) : null,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'gender ' => $this->gender,
            'token' => $this->token,
            'accepted' => $this->accepted,
            'active' => $this->active,
            'createdAt' => $this->created_at,
            'confirmationType' => $this->confirmationType,
            "streamio_id" => $this->streamio_id,
            'streamio_token' => $this->streamio_token,
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
            // 'referralCode' => $this->referralCode->referral_code,
            'lastSeen' => Carbon::parse($this->last_seen)->toISOString()

        ];
    }
}