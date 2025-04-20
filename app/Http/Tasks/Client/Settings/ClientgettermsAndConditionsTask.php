<?php

namespace App\Http\Tasks\Client\Settings;

use App\Http\Resources\API\Client\Settings\ClientTermsAndConditionsResource;
use App\Http\Resources\API\YmtazSettings\YmtazWorkDaysResource;
use App\Http\Tasks\BaseTask;
use App\Models\Contents\Content;
use App\Models\YmtazSettings\YmtazWorkDays;
use Illuminate\Http\Request;

class ClientgettermsAndConditionsTask extends BaseTask
{

    public function run(Request $request)
    {
        $item =new ClientTermsAndConditionsResource(Content::where('type','clientrules')->first());
        return $this->sendResponse(true, 'الشروط والاحكام للعميل', compact('item'), 200);
    }
}
