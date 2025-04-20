<?php

namespace App\Http\Tasks\Client\Services;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Resources\API\Services\ServiceCategoryResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Resources\API\Services\ServicesShortResource;
use App\Http\Resources\API\Services\ServiceSubCategoryResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\Service\Service;
use App\Models\Service\ServiceCategory;
use App\Models\Service\ServiceSubCategory;

class ClientGetSubCategoriesServicesTask extends BaseTask
{

    public function run()
    {
        $items = ServiceCategory::where('status', 1)->orderBy('created_at','desc')->get();
        $items = ServiceCategoryResource::collection($items);
        return $this->sendResponse(true, ' تصنيفات الفرعية ', compact('items'), 200);
    }
}
