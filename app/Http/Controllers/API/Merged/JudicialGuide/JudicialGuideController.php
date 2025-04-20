<?php

namespace App\Http\Controllers\API\Merged\JudicialGuide;

use App\Http\Tasks\Merged\FavouriteLawyers\GetFavouriteLawyersTask;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuideById;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuides;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuidesMainCategories;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuidesSubCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\FavouriteLawyers\CreateFavouriteTask;


class JudicialGuideController extends BaseController
{

    public function getMain(Request $request, GetJudicialGuidesMainCategories $task)
    {
        $task = $task->run();
        return $task;
    }

    public function getSub(Request $request, GetJudicialGuidesSubCategories $task, $id)
    {
        $task = $task->run($id);
        return $task;
    }
    public function getJudicialGuides(Request $request, GetJudicialGuides $task, $id)
    {
        $task = $task->run($id);
        return $task;
    }
    public function getJudicialGuideById(Request $request, GetJudicialGuideById $task, $id)
    {
        $task = $task->run($id);
        return $task;
    }


}
