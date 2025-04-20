<?php

namespace App\Http\Resources\API\LawGuide;

use GeniusTS\HijriDate\Hijri;
use Illuminate\Http\Resources\Json\JsonResource;

class LawGuideResource extends JsonResource
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
        $laws = $this->laws()->paginate($request->perPage ?? 10, page: $request->page ?? 1);
        return [
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
            'number_of_chapters' => $this->number_of_chapters,
            'count' => $this->laws->count() - $this->number_of_chapters,
            'laws' => [
                'data' => LawGuideLawResource::collection($laws),
                'total' => $laws->total(),
                'current_page' => $laws->currentPage(),
                'per_page' => $laws->perPage(),
                'last_page' => $laws->lastPage()
            ]
        ];
    }
}
