<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;

class LawyerGetAdvisoryServicesTypesTask extends BaseTask
{

    public function run()
    {
        $items = AdvisoryServicesTypes::orderBy('created_at','desc')->get();
        $items = AdvisoryServicesTypesResource::collection($items);
        return $this->sendResponse(true, 'انواع خدمات استشارية', compact('items'), 200);
    }
}
