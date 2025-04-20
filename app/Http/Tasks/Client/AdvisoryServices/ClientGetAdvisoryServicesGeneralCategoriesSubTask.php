<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Http\Resources\AdvisoryServicesSubCategoriesResource;

class ClientGetAdvisoryServicesGeneralCategoriesSubTask extends BaseTask
{
    public function run($id, $g_id)
    {
        $subCategories = AdvisoryServicesSubCategory::where('general_category_id', $g_id)->with([
            'levels' => function ($query) {
                $query->whereNull('lawyer_id');
            }
        ])->get();
        $subCategories = AdvisoryServicesSubCategoriesResource::collection($subCategories);

        return $this->sendResponse(true, 'Subcategories fetched successfully', compact('subCategories'), 200);
    }
}
