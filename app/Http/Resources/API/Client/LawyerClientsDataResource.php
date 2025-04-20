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

class LawyerClientsDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        if (!is_null($this->client->image)) {
            $image = asset('uploads/client/profile/image/' . str_replace('\\', '/', $this->client->image));
        } else if (!is_null($this->client->photo)) {
            $image = asset('uploads/lawyer/profile/image/' . str_replace('\\', '/', $this->client->photo));

        } else {
            $image = asset('uploads/person.png');
        }

        if (!is_null($this->client->nationality_rel)) {
            $nationality = new LawyerNationalitiesResource($this->client->nationality_rel);
        } else if (!is_null($this->client->nationality)) {
            $nationality = new LawyerNationalitiesResource($this->client->nationality);
        } else {
            $nationality = null;
        }
        return [
            'id' => $this->client->id,
            'name' => $this->client->myname ? $this->client->myname : $this->client->name,
            'type' => intval($this->client->type),
            'image' => $image,
            'nationality' => $nationality,
            'gender ' => $this->client->gender,
        ];
    }
}
