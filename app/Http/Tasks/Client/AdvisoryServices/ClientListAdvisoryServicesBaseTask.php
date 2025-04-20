<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesBase;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesBaseResource;

class ClientListAdvisoryServicesBaseTask extends BaseTask
{

    public function run()
    {
        $items = AdvisoryServicesBase::orderBy('created_at','desc')->get();
        $items = AdvisoryServicesBaseResource::collection($items);
        return $this->sendResponse(true, 'انواع فئات استشارية', compact('items'), 200);
    }
}
