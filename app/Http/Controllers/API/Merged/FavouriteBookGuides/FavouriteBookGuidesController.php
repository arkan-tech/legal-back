<?php

namespace App\Http\Controllers\API\Merged\FavouriteBookGuides;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\FavouriteBookGuides\CreateFavouriteTask;
use App\Http\Tasks\Merged\FavouriteBookGuides\GetFavouriteBookGuidesTask;

class FavouriteBookGuidesController extends BaseController
{
    public function createFavourite(Request $request, CreateFavouriteTask $task, $id)
    {
        return $task->run($request, $id);
    }

    public function getFavouriteBookGuides(Request $request, GetFavouriteBookGuidesTask $task)
    {
        return $task->run($request);
    }
}
