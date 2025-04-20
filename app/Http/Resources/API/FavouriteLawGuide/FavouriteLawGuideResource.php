<?php

namespace App\Http\Resources\API\FavouriteLawGuide;

use App\Http\Resources\API\LawGuide\LawGuideLawResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteLawGuideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'law' => new LawGuideLawResource($this->law)
        ];
    }
}
