<?php

namespace App\Http\Tasks\Merged\BookGuide;

use App\Http\Resources\BookGuideCategoryResource;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Models\BookGuideCategory;
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

class GetMainBookGuide extends BaseTask
{

    public function run()
    {
        $mainCategories = BookGuideCategory::get();

        $mainCategories = BookGuideCategoryResource::collection($mainCategories);
        return $this->sendResponse(true, 'Book Guide Main Categories', compact('mainCategories'), 200);
    }
}
