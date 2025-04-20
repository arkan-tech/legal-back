<?php

namespace App\Http\Resources;

use GeniusTS\HijriDate\Hijri;
use Illuminate\Http\Resources\Json\JsonResource;

class LawGuideResourceShortForLaw extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $released_at_hijri = Hijri::convertToHijri($this->released_at)->format('Y-m-d');
        $published_at_hijri = Hijri::convertToHijri($this->published_at)->format('Y-m-d');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_en' => $this->name_en,
            'released_at' => $this->released_at,
            'published_at' => $this->published_at,
            'released_at_hijri' => $released_at_hijri,
            'published_at_hijri' => $published_at_hijri,
            'status' => $this->status,
            'release_tool' => $this->release_tool,
            'release_tool_en' => $this->release_tool_en,
            'number_of_chapters' => $this->number_of_chapters,
            'count' => $this->laws->count() - $this->number_of_chapters,
            "lawGuideMainCategory" => [
                "id" => $this->mainCategory->id,
                "name" => $this->mainCategory->name,
            ]
        ];
    }
}
