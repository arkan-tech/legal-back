<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\Reservations\ReservationTypeImportance;
use App\Models\AdvisoryServices\AdvisoryServicesPrices;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategoryPrice;

class DeleteAdvisoryServicePriceTask extends BaseTask
{
    public function run(Request $request, $id)
    {
        $lawyer = Account::find(auth()->user()->id);

        $subCategory = AdvisoryServicesSubCategory::findOrFail($id);

        $lawyerPrices = AdvisoryServicesSubCategoryPrice::where('lawyer_id', $lawyer->id)
            ->where('sub_category_id', $subCategory->id)
            ->get();

        if ($lawyerPrices->isEmpty()) {
            return $this->sendResponse(false, 'There are no advisory service prices to delete', null, 400);
        }

        foreach ($lawyerPrices as $price) {
            $price->delete();
        }

        return $this->sendResponse(true, 'Advisory service prices have been deleted', null, 200);
    }
}
