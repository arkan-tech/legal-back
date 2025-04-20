<?php

namespace App\Http\Tasks\Benefit;

use App\Http\Resources\API\Benefit\TodayBenefitResource;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Models\TodayBenefit\TodayBenefit;

class getBenefitListTask extends BaseTask
{

    public function run()
    {
        $items = TodayBenefitResource::collection(TodayBenefit::orderBy('created_at','desc')->get());

        return $this->sendResponse(true, 'فوائد اليوم', compact('items'), 200);
    }
}
