<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;

class LawyerGetAdvisoryServicesTask extends BaseTask
{

    public function run()
    {
        $items = AdvisoryServices::orderBy('created_at', 'desc')->get();
        $items = AdvisoryServicesResource::collection($items);
        return $this->sendResponse(true, ' خدمات استشارية', compact('items'), 200);
    }
}
