<?php

namespace App\Http\Tasks\Lawyer\DigitalGuidePackages;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\DigitalGuide\DigitalGuidePackage;
use App\Http\Resources\API\DigitalGuide\Packages\DigitalGuidePackagesResource;
use App\Http\Resources\API\DigitalGuide\Packages\SubscribeDigitalGuidePackagesResource;

class CancelPaymentPackageTask extends BaseTask
{

    public function run(Request $request)
    {
        $Lawyer = $this->authLawyer();
        $Lawyer->update([
            'digital_guide_subscription' => 0,
            'digital_guide_subscription_payment_status' => 2
        ]);
        return $this->sendResponse(true, 'Cacnelled', null, 200);
    }
}
