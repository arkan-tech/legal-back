<?php

namespace App\Http\Tasks\Client\RequestLevels;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Resources\API\RequestLevel\RequestLevelResource;
use App\Http\Resources\API\Services\ServiceCategoryResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Resources\API\Services\ServicesShortResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\RequestLevels\RequestLevel;
use App\Models\Service\Service;
use App\Models\Service\ServiceCategory;

class ClientGetRequestLevelsTask extends BaseTask
{

    public function run()
    {
        $items = ClientReservationsImportance::where('status', 1)->orderBy('created_at','desc')->get();
        $items = RequestLevelResource::collection($items);
        return $this->sendResponse(true, ' مستويات الطلبات ', compact('items'), 200);
    }
}
