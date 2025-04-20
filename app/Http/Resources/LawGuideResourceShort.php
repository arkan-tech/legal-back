<?php

namespace App\Http\Resources;

use GeniusTS\HijriDate\Hijri;
use Illuminate\Http\Resources\Json\JsonResource;

class LawGuideResourceShort extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function __construct($resource, $should_return_count = true)
    {
        $this->resource = $resource;
        $this->should_return_count = $should_return_count;
    }
    public function toArray($request)
    {
        $released_at_hijri = Hijri::convertToHijri($this->released_at)->format('Y-m-d');
        $published_at_hijri = Hijri::convertToHijri($this->published_at)->format('Y-m-d');
        $body = [
            'id' => $this->id,
            'name' => $this->name,
            'name_en' => $this->name_en,
            'word_file_ar' => $this->getWordFileArAttribute(),
            'word_file_en' => $this->getWordFileEnAttribute(),
            'pdf_file_ar' => $this->getPdfFileArAttribute(),
            'pdf_file_en' => $this->getPdfFileEnAttribute(),
            'released_at' => $this->released_at,
            'published_at' => $this->published_at,
            'released_at_hijri' => $released_at_hijri,
            'published_at_hijri' => $published_at_hijri,
            'about' => $this->about,
            'about_en' => $this->about_en,
            'status' => $this->status,
            'release_tool' => $this->release_tool,
            'release_tool_en' => $this->release_tool_en,
            "lawGuideMainCategory" => [
                "id" => $this->mainCategory->id,
                "name" => $this->mainCategory->name,
            ]
        ];
        if ($this->should_return_count) {
            $body['number_of_chapters'] = $this->number_of_chapters;
            $body['count'] = $this->laws->count() - $this->number_of_chapters;
        }
        return $body;
    }
}
