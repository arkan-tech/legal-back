<?php

namespace App\Http\Tasks\Client\Services;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\Service\Service;

class ClientGetServicesTask extends BaseTask
{

    public function run()
    {
        $items = Service::where('isHidden', 0)->orderBy('created_at','desc')->get();
        $items = ServicesResource::collection($items);
        return $this->sendResponse(true, ' خدمات ', compact('items'), 200);
    }
}
