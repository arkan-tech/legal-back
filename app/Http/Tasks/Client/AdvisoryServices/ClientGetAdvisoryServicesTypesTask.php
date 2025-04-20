<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;

class ClientGetAdvisoryServicesTypesTask extends BaseTask
{

    public function run()
    {
        $items = AdvisoryServicesTypes::orderBy('created_at', 'desc')->where('isHidden', 0)->with('advisoryService')->with([
            'advisory_services_prices' => function ($query) {
                $query->where('is_ymtaz', 1);
            }
        ])->get();
        $items = AdvisoryServicesTypesResource::collection($items);
        return $this->sendResponse(true, 'انواع خدمات استشارية', compact('items'), 200);
    }
}
