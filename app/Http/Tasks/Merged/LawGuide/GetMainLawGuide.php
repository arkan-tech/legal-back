<?php

namespace App\Http\Tasks\Merged\LawGuide;

use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Models\LawGuideMainCategory;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Models\JudicialGuide\JudicialGuideSubCategory;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Http\Resources\API\JudicialGuide\JudicialGuideResource;
use App\Http\Resources\API\LawGuide\LawGuideMainCategoryResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideSubCategoryResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;

class GetMainLawGuide extends BaseTask
{

    public function run()
    {
        $mainCategories = LawGuideMainCategory::orderBy('order')->get();

        $mainCategories = $mainCategories->map(function ($category) {
            return new LawGuideMainCategoryResource($category, true);
        });

        return $this->sendResponse(true, 'Law Guide Main Categories', compact('mainCategories'), 200);
    }
}
