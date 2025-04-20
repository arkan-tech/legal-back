<?php

namespace App\Http\Resources\API\Client;

use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerShortCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Nationalities\LawyerNationalitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerShortRegionsResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ClientLawyersDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        if (!is_null($this->photo)) {
            $image = asset('uploads/lawyer/profile/image/' . str_replace('\\', '/', $this->photo));

        } else {
            $image = asset('uploads/person.png');
        }

        $nationality = new LawyerNationalitiesResource($this->nationality_rel);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => intval($this->type),
            'image' => $image,
            'nationality' => $nationality,
            'gender ' => $this->gender,
        ];
    }
}
