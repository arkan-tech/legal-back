<?php

namespace App\Http\Tasks\Merged\FavouriteLearningPathItems;

use App\Http\Tasks\BaseTask;
use App\Models\FavouriteLearningPathItem;
use Illuminate\Http\Request;
use App\Http\Resources\API\FavouriteLearningPathItem\FavouriteLearningPathItemResource;

class GetFavouriteLearningPathItemsTask extends BaseTask
{
    public function run(Request $request, $id)
    {
        $user = auth()->user();

        $favouriteLearningPathItems = FavouriteLearningPathItem::where('account_id', $user->id)
            ->with([
                'learningPathItem.learningPath',
                'learningPathItem.lawGuideLaw.lawGuide',
                'learningPathItem.bookGuideSection.bookGuide'
            ])->whereHas('learningPathItem.learningPath', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->get();


        return $this->sendResponse(
            true,
            'Favourite Learning Path Items',
            [
                'favouriteLearningPathItems' => FavouriteLearningPathItemResource::collection($favouriteLearningPathItems),
            ],
            200
        );
    }
}
