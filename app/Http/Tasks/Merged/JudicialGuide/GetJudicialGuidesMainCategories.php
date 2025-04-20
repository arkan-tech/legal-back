<?php

namespace App\Http\Tasks\Merged\JudicialGuide;

use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Models\Reservations\AvailableReservation;

class GetJudicialGuidesMainCategories extends BaseTask
{

    public function run()
    {
        $judicialGuidesMainCategories = JudicialGuideMainCategory::get();
        $judicialGuidesMainCategories = JudicialGuideMainCategoryResource::collection($judicialGuidesMainCategories);
        return $this->sendResponse(true, 'Judicial Guide Main Categories', compact('judicialGuidesMainCategories'), 200);
    }
}
