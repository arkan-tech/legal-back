<?php

namespace App\Http\Tasks\Merged\BookGuide;

use App\Http\Resources\BookGuideSectionResource;
use App\Models\BookGuideSection;
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

class GetBookById extends BaseTask
{

    public function run($sectionId)
    {
        $book = BookGuideSection::find($sectionId);
        $book = new BookGuideSectionResource($book);
        return $this->sendResponse(true, 'Section by id', compact('book'), 200);
    }
}
