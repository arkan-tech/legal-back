<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategoryPrice;

class HideAdvisoryServicePriceTask extends BaseTask
{
    public function run(Request $request, $id)
    {
        $lawyer = Account::find(auth()->user()->id);
        $status = $request->status;

        $subCategory = AdvisoryServicesSubCategory::findOrFail($id);

        $lawyerPrices = AdvisoryServicesSubCategoryPrice::where('lawyer_id', $lawyer->id)
            ->where('sub_category_id', $subCategory->id)
            ->get();

        if ($lawyerPrices->isEmpty()) {
            return $this->sendResponse(false, 'There are no advisory services to hide or unhide', null, 400);
        }

        foreach ($lawyerPrices as $price) {
            $price->is_hidden = $status;
            $price->save();
        }

        return $this->sendResponse(true, 'Advisory service prices have been updated', null, 200);
    }
}
