<?php

namespace App\Http\Resources\API\DigitalGuide\Categories;

use JsonSerializable;
use Illuminate\Http\Request;
use App\Models\Lawyer\LawyerSections;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class DigitalGuideCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $lawyerCount = LawyerSections::whereHas('lawyer', function ($query) {
            $query->where('show_at_digital_guide', 1)->whereHas('lawyer', function ($query2) {
                $query2->where('status', 2);
            });
        })->where('section_id', $this->id)->count();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'need_license' => intval($this->need_license),
            'lawyers_count' => intval($lawyerCount),
        ];
    }
}
