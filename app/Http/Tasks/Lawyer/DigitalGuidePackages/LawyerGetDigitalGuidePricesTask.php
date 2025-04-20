<?php

namespace App\Http\Tasks\Lawyer\DigitalGuidePackages;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\DigitalGuide\DigitalGuidePackage;
use App\Http\Resources\API\DigitalGuide\Packages\DigitalGuidePackagesResource;

class LawyerGetDigitalGuidePricesTask extends BaseTask
{

    public function run()
    {
        $user = $this->authLawyer();
        $items = DigitalGuidePackage::where('status', 1)->get();
        $items = DigitalGuidePackagesResource::collection($items);
        return $this->sendResponse(true, "Test",compact('items'), 200);
    }
}
