<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;

class ClientListAdvisoryServicesBasePaymentMethodTask extends BaseTask
{

    public function run($id)
    {
        $items = AdvisoryServices::where('payment_category_id', $id)->get();
        $items = AdvisoryServicesResource::collection($items);
        return $this->sendResponse(true, 'خدمات استشارية', compact('items'), 200);
    }
}
