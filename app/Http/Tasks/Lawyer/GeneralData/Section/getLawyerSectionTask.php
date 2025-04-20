<?php

namespace App\Http\Tasks\Lawyer\GeneralData\Section;


use App\Http\Resources\API\DigitalGuide\Categories\DigitalGuideCategoriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Section\LawyerSectionResource;
use App\Http\Tasks\BaseTask;
use App\Models\DigitalGuide\DigitalGuideCategories;


class getLawyerSectionTask extends BaseTask
{
    public function run()
    {
        $DigitalGuideCategories = DigitalGuideCategoriesResource::collection(DigitalGuideCategories::where('status', 1)->orderBy('created_at','desc')->get());
        return $this->sendResponse(true, '  المهن', compact('DigitalGuideCategories'), 200);
    }

}
