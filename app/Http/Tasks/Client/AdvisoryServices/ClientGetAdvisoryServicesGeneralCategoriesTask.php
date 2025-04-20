<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Resources\AdvisoryServicesGeneralCategoryResource;
use App\Models\AdvisoryServices\AdvisoryServicesGeneralCategory;

class ClientGetAdvisoryServicesGeneralCategoriesTask
{
    public function run($id)
    {
        $categories = AdvisoryServicesGeneralCategory::where('payment_category_type_id', $id)->get();
        $categories = AdvisoryServicesGeneralCategoryResource::collection($categories);
        return [
            'status' => true,
            'message' => 'General categories fetched successfully',
            'data' => $categories,
            'code' => 200
        ];
    }
}
