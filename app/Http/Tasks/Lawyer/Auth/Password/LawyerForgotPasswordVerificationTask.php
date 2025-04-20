<?php

namespace App\Http\Tasks\Lawyer\Auth\Password;

use App\Http\Requests\API\Lawyer\Auth\Password\LawyerForgotPasswordVerificationRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;

class LawyerForgotPasswordVerificationTask extends BaseTask
{
    public function run(LawyerForgotPasswordVerificationRequest $request)
    {
        $lawyer = Lawyer::where('pass_code',$request->code)->where('pass_reset',1)->first();
        if (is_null($lawyer)){
            return $this->sendResponse(false, 'رمز التحقق غير صالح', null, 422);
        }else{
//            $client->update([
//                'pass_code' => null,
//                'pass_reset' => 0,
//            ]);
            $pass_code= $lawyer->pass_code;
            return $this->sendResponse(true, 'تم التحقق , توجه الى تغيير كلمة المرور', compact('pass_code'), 200);

        }

    }
}
