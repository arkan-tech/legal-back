<?php

namespace App\Http\Resources\API\Library\Books;

use App\Models\Library\Books\BookRate;
use App\Models\Library\Books\ClientBookFavorite;
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
        $rates = BookRate::where('book_id',$this->id)->pluck('rate')->toArray();
        $avg = CalculateRateAvg($rates);
        $client = auth()->guard('api_client')->user();
        if (!is_null($client)){
            $fav_books = ClientBookFavorite::where('client_id', $client->id)->pluck('book_id')->toArray();

            $check = in_array($this->id, $fav_books) ? 1 : 0;
        }else{
            $check=null;

        }
        return [
            'id'=>$this->id,
            'image'=>$this->Image,
            'title'=>$this->Title,
            'author'=>$this->author,
            'price'=>$this->price,
            'description'=>$this->details,
            'file'=>$this->Link,
            'file_en'=>$this->link_en,
            'category'=>new BooksCategoryResource($this->cat),
            'rate'=>$avg,
            'is_favorite' => $check,
        ];
    }
}
