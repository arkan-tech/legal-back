<?php

namespace App\Http\Resources\API\FavouriteBookGuide;

use App\Http\Resources\BookGuideSectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteBookGuideResource extends JsonResource
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
            'section' => new BookGuideSectionResource($this->section)
        ];
    }
}
