<?php

namespace App\Http\Resources\API\Lawyer\GeneralData\Section;

use App\Http\Resources\API\DigitalGuide\Categories\DigitalGuideCategoriesResource;
use App\Models\DigitalGuide\DigitalGuideCategories;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LawyerSectionResourcePrivate extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function OriginalSection()
    {
        $section = DigitalGuideCategories::where('id', $this->pivot->section_id)->first();
        return $section;
    }
    public function toArray($request)
    {
        $section = $this->OriginalSection();

        return [
            'id' => $this->id,
            'section' => new DigitalGuideCategoriesResource($section),
            // 'lawyer_license_no' => $this->pivot->licence_no,
            // 'lawyer_license_file' => !empty($this->pivot->licence_file) || !is_null($this->pivot->licence_file) ? asset('uploads/account/license_file/' . $this->pivot->licence_file) : null,
        ];
    }
}
