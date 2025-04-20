<?php

namespace App\Http\Tasks\Merged\FavouriteLearningPathItems;

use App\Http\Tasks\BaseTask;
use App\Models\FavouriteLearningPathItem;
use Illuminate\Http\Request;

class CreateFavouriteTask extends BaseTask
{
    public function run(Request $request, $id)
    {
        $user = auth()->user();

        $favouriteLearningPathItem = FavouriteLearningPathItem::where('account_id', $user->id)
            ->where('learning_path_item_id', $id)
            ->first();

        if ($favouriteLearningPathItem) {
            $favouriteLearningPathItem->delete();
            return $this->sendResponse(true, 'تم ازالته من المفضلة بنجاح', null, 200);
        } else {
            $favouriteLearningPathItem = new FavouriteLearningPathItem();
            $favouriteLearningPathItem->learning_path_item_id = $id;
            $favouriteLearningPathItem->account_id = $user->id;
            $favouriteLearningPathItem->save();
            return $this->sendResponse(true, 'تم اضافته الى المفضلة بنجاح', null, 200);
        }
    }
}
