<?php

namespace App\Http\Resources\API\Client\FavoritesLawyers;

use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ClientFavoritesLawyersResource extends JsonResource
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
            'lawyer' =>  new LawyerShortDataResource($this->lawyer),
        ];
    }
}
