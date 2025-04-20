<?php

namespace App\Http\Tasks\Client\DigitalGuide\Categories;

use App\Http\Resources\API\DigitalGuide\Categories\DigitalGuideCategoriesResource;
use App\Http\Tasks\BaseTask;
use App\Models\DigitalGuide\DigitalGuideCategories;
use Illuminate\Http\Request;

class getAllDigitalGuideCategoriesTask extends BaseTask
{

    public function run(Request $request)
    {
        $DigitalGuideCategories = DigitalGuideCategories::where('status', 1)->orderBy('created_at', 'desc')->get();
        $categories = DigitalGuideCategoriesResource::collection($DigitalGuideCategories);
        return $this->sendResponse(true, 'تصنيفات الدليل الرقمي', compact('categories'), 200);
    }
}
