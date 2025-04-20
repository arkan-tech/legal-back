<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesBase;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesBaseResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;

class ClientListAdvisoryTypesByAdvisoryServiceId extends BaseTask
{

    public function run($id)
    {
        $items = AdvisoryServicesTypes::where("advisory_service_id", $id)->where('isHidden', 0)->with([
            'advisory_services_prices' => function ($query) {
                $query->where("is_ymtaz", 1);
            }
        ])->orderBy('created_at', 'desc')->get();
        $items = AdvisoryServicesTypesResource::collection($items);
        return $this->sendResponse(true, 'انواع الاستشارات', compact('items'), 200);
    }
}
