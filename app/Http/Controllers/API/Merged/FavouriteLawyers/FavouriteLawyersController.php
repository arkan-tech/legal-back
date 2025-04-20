<?php

namespace App\Http\Controllers\API\Merged\FavouriteLawyers;

use App\Http\Tasks\Merged\FavouriteLawyers\GetFavouriteLawyersTask;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\FavouriteLawyers\CreateFavouriteTask;


class FavouriteLawyersController extends BaseController
{

    public function createFavourite(Request $request, CreateFavouriteTask $task, $id)
    {
        $task = $task->run($request, $id);
        return $task;
    }

    public function getFavouriteLawyers(Request $request, GetFavouriteLawyersTask $task)
    {
        $task = $task->run($request);
        return $task;
    }
}
