<?php

namespace App\Http\Resources\API\FavouriteLearningPathItem;

use App\Http\Resources\BookGuideResourceShort;
use App\Http\Resources\LawGuideResourceShort;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteLearningPathItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $item = $this->learningPathItem;
        $name = $item->item_type === 'law-guide' ?
            $item->lawGuideLaw->name :
            $item->bookGuideSection->name;

        $itemData = [
            'id' => $this->id,
            'learning_path_item_id' => $item->id,
            'name' => $name,
            'type' => $item->item_type,
            'learning_path' => [
                'id' => $item->learningPath->id,
                'title' => $item->learningPath->title
            ]
        ];

        if ($item->item_type == 'law-guide') {
            $itemData['subcategory'] = new LawGuideResourceShort($item->lawGuideLaw->lawGuide, false);
        } else if ($item->item_type == 'book-guide') {
            $itemData['subcategory'] = new BookGuideResourceShort($item->bookGuideSection->bookGuide, false);
        }

        return $itemData;
    }
}
