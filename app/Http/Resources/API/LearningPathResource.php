<?php
namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class LearningPathResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'items' => $this->items()->with('progress')->get(),
        ];
    }
}
