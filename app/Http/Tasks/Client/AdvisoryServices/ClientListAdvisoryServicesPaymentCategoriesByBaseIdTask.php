<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesBase;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesBaseResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesPaymentCategoryResource;

class ClientListAdvisoryServicesPaymentCategoriesByBaseIdTask extends BaseTask
{

    public function run($id)
    {
        $items = AdvisoryServicesPaymentCategory::where('advisory_service_base_id', $id)->orderBy('created_at','desc')->get();
        $items = AdvisoryServicesPaymentCategoryResource::collection($items);
        return $this->sendResponse(true, 'انواع الباقات الاستشارية', compact('items'), 200);
    }
}
