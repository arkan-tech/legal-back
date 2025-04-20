<?php

namespace App\Http\Resources\API\Benefit;

use Illuminate\Http\Resources\Json\JsonResource;

class TodayBenefitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'image'=>$this->image,
            'text'=>$this->text,
            'date'=>GetArabicDate2($this->created_at)
        ];
    }
}
