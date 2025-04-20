<?php

namespace App\Http\Tasks\Merged\JudicialGuide;

use App\Http\Resources\API\JudicialGuide\JudicialGuideResource;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Models\JudicialGuide\JudicialGuide;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Models\JudicialGuide\JudicialGuideSubCategory;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideSubCategoryResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;

class GetJudicialGuideById extends BaseTask
{

    public function run($id)
    {
        $judicialGuide = JudicialGuide::findOrFail($id);
        $judicialGuide = new JudicialGuideResource($judicialGuide);
        return $this->sendResponse(true, 'Judicial Guide by id', compact('judicialGuide'), 200);
    }
}
