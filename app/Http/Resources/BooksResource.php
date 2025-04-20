<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BooksResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'author_name' => $this->author_name,
            'file' => $this->file,
            'sub_category' => [
                'id' => $this->subCategory->id,
                'name' => $this->subCategory->name,
                'main_category' => [
                    'id' => $this->subCategory->mainCategory->id,
                    'name' => $this->subCategory->mainCategory->name,
                ]
            ]
        ];
    }
}
