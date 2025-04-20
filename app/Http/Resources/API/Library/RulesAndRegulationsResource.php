<?php

namespace App\Http\Resources\API\Library;

use App\Http\Resources\API\Library\Books\BooksCategoryResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class RulesAndRegulationsResource extends JsonResource
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
            'category' => new BooksCategoryResource($this->MainCategory),
            'sub_category' => new BooksCategoryResource($this->SubCategory),
            'name' => $this->name,
            'release_date' => $this->release_date,
            'publication_date' => $this->publication_date,
            'status' => $this->status,
            'about' => $this->about,
            'law_name' => $this->law_name,
            'law_description' => $this->law_description,
            'text' => $this->text,
            'world_file' => $this->world_file,
            'pdf_file' => $this->pdf_file,
            'release_tools' => RulesAndRegulationsReleaseToolsResource::collection($this->ReleasTools),

        ];
    }
}
