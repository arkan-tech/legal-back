<?php

namespace App\Http\Tasks\Merged\JudicialGuide;

use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Models\JudicialGuide\JudicialGuideSubCategory;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Http\Resources\API\JudicialGuide\JudicialGuideResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideSubCategoryResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;

class GetJudicialGuides extends BaseTask
{

    public function run($id)
    {
        $judicialGuidesSubCategory = JudicialGuideSubCategory::findOrFail($id);

        $judicialGuides = JudicialGuideResource::collection($judicialGuidesSubCategory->judicialGuides);
        return $this->sendResponse(true, 'Judicial Guides', compact('judicialGuides'), 200);
    }
}
