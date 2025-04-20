<?php

namespace App\Http\Tasks\Merged\JudicialGuide;

use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideSubCategoryResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Models\Reservations\AvailableReservation;

class GetJudicialGuidesSubCategories extends BaseTask
{

    public function run($id)
    {
        $judicialGuidesMainCategory = JudicialGuideMainCategory::findOrFail($id);
        $judicialGuidesSubCategories = JudicialGuideSubCategoryResource::collection($judicialGuidesMainCategory->subCategories);
        return $this->sendResponse(true, 'Judicial Guide Sub Categories', compact('judicialGuidesSubCategories'), 200);
    }
}
