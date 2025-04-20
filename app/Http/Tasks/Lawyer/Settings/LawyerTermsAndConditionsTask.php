<?php

namespace App\Http\Tasks\Lawyer\Settings;

use App\Http\Requests\API\Lawyer\Auth\Login\LawyerLoginRequest;
use App\Http\Resources\API\Client\Settings\ClientTermsAndConditionsResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Tasks\BaseTask;
use App\Models\Contents\Content;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LawyerTermsAndConditionsTask extends BaseTask
{
    public function run(Request $request)
    {
        $item =new ClientTermsAndConditionsResource(Content::where('type','lawyersrules')->first());
        return $this->sendResponse(true, 'الشروط والاحكام مقدم الخدمة', compact('item'), 200);

    }
}
