<?php

namespace App\Http\Resources\API\LawGuide;

use App\Http\Resources\LawGuideResourceShort;
use App\Http\Resources\LawGuideResourceShortForLaw;
use Illuminate\Http\Resources\Json\JsonResource;

class LawGuideLawResource extends JsonResource
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
            "name" => $this->name,
            'name_en' => $this->name_en,
            "law" => $this->law,
            "law_en" => $this->law_en,
            "changes" => $this->changes,
            "changes_en" => $this->changes_en,
            "lawGuide" => new LawGuideResourceShortForLaw($this->lawGuide)

        ];
    }
}

