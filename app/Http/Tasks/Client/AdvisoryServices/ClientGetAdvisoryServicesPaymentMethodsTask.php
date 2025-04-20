<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesPaymentCategoryResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;

class ClientGetAdvisoryServicesPaymentMethodsTask extends BaseTask
{

    public function run()
    {
        $items = AdvisoryServicesPaymentCategory::where('status', 1)->orderBy('created_at', 'ASC')->get();
        $items = AdvisoryServicesPaymentCategoryResource::collection($items);
        return $this->sendResponse(true, 'اقسام الدفع', compact('items'), 200);
    }
}
