<?php

namespace App\Http\Resources\API\Services;

use App\Http\Resources\API\DigitalGuide\Categories\DigitalGuideCategoriesResource;
use App\Models\DigitalGuide\DigitalGuideCategories;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ServiceSectionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function OriginalSection()
    {
        $section  = DigitalGuideCategories::where('id',$this->section_id)->first();
        return $section;
    }
    public function toArray($request)
    {
        $section = $this->OriginalSection();

        return [
            'id' => $this->id,
            'section' =>new DigitalGuideCategoriesResource($section),
        ];
    }
}
