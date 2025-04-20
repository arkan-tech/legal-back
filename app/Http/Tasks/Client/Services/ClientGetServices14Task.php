<?php

namespace App\Http\Tasks\Client\Services;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Resources\API\Services\ServicesShortResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\Service\Service;

class ClientGetServices14Task extends BaseTask
{

    public function run()
    {
        $items = Service::where('isHidden', 1)->take(14)->orderBy('created_at','desc')->get();
        $items = ServicesShortResource::collection($items);
        return $this->sendResponse(true, ' خدمات ', compact('items'), 200);
    }
}