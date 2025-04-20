<?php

namespace App\Http\Resources\API\Services;

use App\Http\Resources\API\Lawyer\GeneralData\Section\LawyerSectionResource;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\Service\ServiceSections;
use App\Models\Service\ServiceYmtazLevelPrices;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ServicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $sections_ids = ServiceSections::where('service_id', $this->id)->pluck('section_id')->toArray();
        $sections = ServiceSectionsResource::collection(DigitalGuideCategories::whereIN('id', $sections_ids)->get());
        $ymtaz_levels_prices = ServiceYmtazLevelPricesResource::collection(ServiceYmtazLevelPrices::where('service_id', $this->id)->get());
        return [
            'id' => $this->id,
            'title' => $this->title,
            'intro' => $this->intro,
            'details' => $this->details,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'ymtaz_price' => $this->ymtaz_price,
            'need_appointment' => $this->need_appointment,
            'ymtaz_levels_prices' => $ymtaz_levels_prices,
        ];
    }
}

class ServicesShortResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'intro' => $this->intro,
            'details' => $this->details,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'ymtaz_price' => $this->ymtaz_price,
            'need_appointment' => $this->need_appointment,
        ];
    }
}
