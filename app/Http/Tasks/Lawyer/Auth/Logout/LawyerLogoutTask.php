<?php

namespace App\Http\Tasks\Lawyer\Auth\Logout;

use App\Http\Requests\API\Client\Auth\Login\ClientLoginRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Tasks\BaseTask;
use App\Models\Service\ServiceUser;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LawyerLogoutTask extends BaseTask
{
    public function run(Request $request)
    {
        auth()->guard('api_lawyer')->logout();
        return $this->sendResponse(true, 'تم  تسجيل الخروج بنجاح',null, 200);
    }
}
