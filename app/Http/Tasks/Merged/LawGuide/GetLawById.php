<?php

namespace App\Http\Tasks\Merged\LawGuide;

use App\Models\LawGuide;
use App\Models\LawGuideLaw;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Models\LawGuideMainCategory;
use App\Http\Resources\LawGuideResourceShort;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\API\LawGuide\LawGuideResource;
use App\Models\JudicialGuide\JudicialGuideSubCategory;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Http\Resources\API\LawGuide\LawGuideLawResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideSubCategoryResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;

class GetLawById extends BaseTask
{

    public function run($lawId)
    {
        $law = LawGuideLaw::find($lawId);
        $law = new LawGuideLawResource($law);
        return $this->sendResponse(true, 'Law by id', compact('law'), 200);
    }
}
