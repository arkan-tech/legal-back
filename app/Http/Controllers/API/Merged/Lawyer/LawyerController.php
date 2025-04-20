<?php

namespace App\Http\Controllers\API\Merged\Lawyer;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\Lawyer\GetNewAdvisoriesTask;
use App\Http\Tasks\Merged\Lawyer\GetLawyerServicesTask;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuides;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuideById;
use App\Http\Tasks\Merged\FavouriteLawyers\CreateFavouriteTask;
use App\Http\Tasks\Merged\FavouriteLawyers\GetFavouriteLawyersTask;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuidesSubCategories;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuidesMainCategories;


class LawyerController extends BaseController
{

    public function getLawyerServices(Request $request, GetLawyerServicesTask $task, $id)
    {
        $task = $task->run($id);
        return $task;
    }

    public function getNewAdvisories(Request $request, GetNewAdvisoriesTask $task)
    {
        $task = $task->run();
        return $task;
    }

}
