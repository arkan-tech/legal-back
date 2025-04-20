<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookGuideCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function __construct($resource, $should_show_count = true)
    {
        $this->resource = $resource;
        $this->should_show_count = $should_show_count;
    }
    public function toArray($request)
    {
        $body = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        if ($this->should_show_count) {
            $body['count'] = $this->bookGuides->count();
        }

        return $body;
    }
}
