<?php

namespace App\Http\Tasks\Merged\FavouriteLearningPathItems;

use App\Http\Tasks\BaseTask;
use App\Models\FavouriteLearningPathItem;
use Illuminate\Http\Request;
use App\Http\Resources\API\FavouriteLearningPathItem\FavouriteLearningPathItemResource;

class GetFavouriteLearningPathItemsTaskById extends BaseTask
{
    public function run($learningPathId)
    {
        $user = auth()->user();

        $favouriteLearningPathItems = FavouriteLearningPathItem::where('account_id', $user->id)->with([
            'learningPathItem.learningPath',
            'learningPathItem.lawGuideLaw.lawGuide',
            'learningPathItem.bookGuideSection.bookGuide'
        ])->whereHas('learningPathItem.learningPath', function ($query) use ($learningPathId) {
            $query->where('id', $learningPathId);
        })->get();

        // Calculate analytics
        $analytics = [
            'total' => $favouriteLearningPathItems->count(),
            'law_guides' => $favouriteLearningPathItems->filter(function ($item) {
                return $item->learningPathItem->item_type === 'law-guide';
            })->count(),
            'book_guides' => $favouriteLearningPathItems->filter(function ($item) {
                return $item->learningPathItem->item_type === 'book-guide';
            })->count(),
        ];

        return $this->sendResponse(
            true,
            'Favourite Learning Path Items',
            [
                'favouriteLearningPathItems' => FavouriteLearningPathItemResource::collection($favouriteLearningPathItems),
                'analytics' => $analytics
            ],
            200
        );
    }
}
