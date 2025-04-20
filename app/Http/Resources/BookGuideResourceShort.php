<?php

namespace App\Http\Resources;

use GeniusTS\HijriDate\Hijri;
use Illuminate\Http\Resources\Json\JsonResource;

class BookGuideResourceShort extends JsonResource
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
            'word_file' => $this->getWordFileAttribute(),
            'pdf_file' => $this->getPdfFileAttribute(),
            'released_at' => $this->released_at,
            'published_at' => $this->published_at,
            'released_at_hijri' => $released_at_hijri,
            'published_at_hijri' => $published_at_hijri,
            'about' => $this->about,
            'status' => $this->status,
            'release_tool' => $this->release_tool,
            "bookGuideCategory" => [
                "id" => $this->category->id,
                "name" => $this->category->name,
            ]
        ];
        if ($this->should_return_count) {
            $body['number_of_chapters'] = $this->number_of_chapters;
            $body['count'] = $this->sections->count() - $this->number_of_chapters;
        }
        return $body;
    }
}
