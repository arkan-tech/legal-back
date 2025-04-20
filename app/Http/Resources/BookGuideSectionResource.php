<?php

namespace App\Http\Resources;

use App\Http\Resources\BookGuideResourceShort;
use Illuminate\Http\Resources\Json\JsonResource;

class BookGuideSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'section_text' => $this->section_text,
            'changes' => $this->changes,
            'book_guide' => new BookGuideResourceShort($this->bookGuide),
        ];
    }
}
