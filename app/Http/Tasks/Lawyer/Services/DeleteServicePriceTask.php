<?php

namespace App\Http\Tasks\Lawyer\Services;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Service\Service;
use App\Models\Lawyer\LawyersServicesPrice;

class DeleteServicePriceTask extends BaseTask
{
    public function run(Request $request, $id)
    {
        $lawyer = Account::find(auth()->user()->id);

        $services = Service::with([
            'lawyerPrices' => function ($query) use ($lawyer) {
                $query->where('account_id', $lawyer->id);
            },
        ])->findOrFail($id);
        if (count($services->lawyerPrices) == 0) {
            return $this->sendResponse(false, 'There are no services to delete', null, 400);
        }
        foreach ($services->lawyerPrices as $servicePrice) {
            $servicePrice->delete();
        }

        return $this->sendResponse(true, 'Service has been deleted', null, 200);

    }
}
