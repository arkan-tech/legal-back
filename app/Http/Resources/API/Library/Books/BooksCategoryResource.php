<?php

namespace App\Http\Resources\API\Library\Books;

use Illuminate\Http\Resources\Json\JsonResource;

class BooksCategoryResource extends JsonResource
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
            'title'=>$this->title,
            'description'=>$this->description,
            'image'=>$this->image,
//            'sub_cat_count'=>count(GetBooksSubCat($this->id))
        ];
    }
}
