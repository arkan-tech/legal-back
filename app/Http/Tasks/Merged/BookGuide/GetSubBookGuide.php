<?php

namespace App\Http\Tasks\Merged\BookGuide;

use App\Http\Resources\BookGuideResource;
use App\Models\BookGuide;
use App\Models\LawGuide;
use App\Models\LawGuideLaw;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
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

class GetSubBookGuide extends BaseTask
{

    public function run(Request $request, $subId)
    {
        $bookGuide = BookGuide::find($subId);
        $bookGuide = new BookGuideResource($bookGuide);
        return $this->sendResponse(true, 'Book Guide by id', compact('bookGuide'), 200);
    }
}
