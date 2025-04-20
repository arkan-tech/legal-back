<?php

namespace App\Http\Tasks\Lawyer\DigitalGuidePackages;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\DigitalGuide\DigitalGuidePackage;
use App\Http\Resources\API\DigitalGuide\Packages\DigitalGuidePackagesResource;
use App\Http\Resources\API\DigitalGuide\Packages\SubscribeDigitalGuidePackagesResource;

class CompletePaymentPackageTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $Lawyer = $this->authLawyer();
        $Lawyer->update([
            'digital_guide_subscription' => 1,
            'digital_guide_subscription_payment_status' => 1,
            'show_at_digital_guide' => 1
        ]);
        return $this->sendResponse(true, 'Done', null, 200);
    }
}
