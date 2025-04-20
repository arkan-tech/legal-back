<?php

namespace App\Http\Tasks\Lawyer\Auth\Login;

use App\Http\Requests\API\Client\Auth\Login\ClientLoginRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LawyerCheckTask extends BaseTask
{
    public function run(Request $request)
    {

        $lawyer = $this->authLawyer();

        if (is_null($lawyer)) {
            return $this->sendResponse(false, 'غير موجود ', null, 404);
        }


        if ($lawyer->accepted == 0) {
            return $this->sendResponse(false, 'نأسف , لقد تم تعليق حسابك من الادارة  , ', null, 401);
        }
        return $this->sendResponse(true, 'مسموح', null, 200);

    }


}
