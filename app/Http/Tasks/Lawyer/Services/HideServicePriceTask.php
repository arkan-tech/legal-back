<?php

namespace App\Http\Tasks\Lawyer\Services;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Service\Service;
use App\Models\Lawyer\LawyersServicesPrice;

class HideServicePriceTask extends BaseTask
{
    public function run(Request $request, $id)
    {
        $lawyer = Account::find(auth()->user()->id);
        $status = $request->status;
        $services = Service::with([
            'lawyerPrices' => function ($query) use ($lawyer) {
                $query->where('account_id', $lawyer->id);
            },
        ])->findOrFail($id);
        if (count($services->lawyerPrices) == 0) {
            return $this->sendResponse(false, 'There are no services to hide', null, 400);
        }
        foreach ($services->lawyerPrices as $service) {
            $service->isHidden = $status;
            $service->save();
        }

        return $this->sendResponse(true, 'Service has been hidden', null, 200);

    }
}
