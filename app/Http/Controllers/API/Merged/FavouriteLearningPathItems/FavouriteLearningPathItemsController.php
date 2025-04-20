<?php

namespace App\Http\Controllers\API\Merged\FavouriteLearningPathItems;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\FavouriteLearningPathItems\CreateFavouriteTask;
use App\Http\Tasks\Merged\FavouriteLearningPathItems\GetFavouriteLearningPathItemsTask;

class FavouriteLearningPathItemsController extends BaseController
{
    public function createFavourite(Request $request, CreateFavouriteTask $task, $id)
    {
        return $task->run($request, $id);
    }

    public function getFavouriteLearningPathItems(Request $request, GetFavouriteLearningPathItemsTask $task, $id)
    {
        return $task->run($request, $id);
    }
}
