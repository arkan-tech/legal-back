<?php

namespace App\Http\Resources\API\LawGuide;

use Illuminate\Http\Resources\Json\JsonResource;

class LawGuideMainCategoryResource extends JsonResource
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
        $should_return_count = $this->should_return_count;

        $body = [
            'id' => $this->id,
            'name' => $this->name,
            'name_en' => $this->name_en,
            // 'lawGuides' => LawGuideResource::collection($this->lawGuides)
        ];
        if ($should_return_count) {
            $body['count'] = $this->lawGuides->count();
        }
        return $body;
    }
}
