<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Tasks\BaseTask;
use App\Models\PaymentCategoryType;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesPaymentCategoryResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesPaymentCategoryTypeResource;

class ClientGetAdvisoryServicesPaymentCategoriesTypesTask extends BaseTask
{

    public function run()
    {
        $items = PaymentCategoryType::get();
        $items = AdvisoryServicesPaymentCategoryTypeResource::collection($items);
        return $this->sendResponse(true, 'وسائل الأستشارة', compact('items'), 200);
    }
}
