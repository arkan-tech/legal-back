<?php

namespace App\Http\Controllers\API\Merged\FavouriteLawGuides;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\FavouriteLawGuides\CreateFavouriteTask;
use App\Http\Tasks\Merged\FavouriteLawGuides\GetFavouriteLawGuidesTask;

class FavouriteLawGuidesController extends BaseController
{
    public function createFavourite(Request $request, CreateFavouriteTask $task, $id)
    {
        return $task->run($request, $id);
    }

    public function getFavouriteLawGuides(Request $request, GetFavouriteLawGuidesTask $task)
    {
        return $task->run($request);
    }
}
