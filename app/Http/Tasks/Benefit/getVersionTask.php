<?php

namespace App\Http\Tasks\Benefit;

use App\Models\Version;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Models\TodayBenefit\TodayBenefit;
use App\Http\Resources\API\Benefit\TodayBenefitResource;

class getVersionTask extends BaseTask
{

    public function run()
    {
        $version = Version::latest('created_at')->first();
        return $this->sendResponse(true, 'اخر نسخة', compact('version'), 200);
    }
}
