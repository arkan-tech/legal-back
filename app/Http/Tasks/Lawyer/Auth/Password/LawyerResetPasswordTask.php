<?php

namespace App\Http\Tasks\Lawyer\Auth\Password;

use App\Http\Requests\API\Lawyer\Auth\Password\LawyerResetPasswordRequest;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Tymon\JWTAuth\Facades\JWTAuth;

class LawyerResetPasswordTask extends BaseTask
{

    public function run(LawyerResetPasswordRequest $request)
    {
        $lawyer = Lawyer::where('pass_code', $request->code)->where('pass_reset', 1)->first();
        if (!$lawyer) {
            return $this->sendResponse(false, 'رمز التحقق غير صالح', null, 422);
        }
        $lawyer->update([
            'pass_code' => null,
            'pass_reset' => 0,
            'password' => bcrypt($request->password),
        ]);
        $token = JWTAuth::fromUser($lawyer);
        $lawyer->injectToken($token);
        $lawyer = new LawyerDataResource($lawyer);
        return $this->sendResponse(true, 'تم تعديل كلمة المرور بنجاح', compact('lawyer'), 200);
    }

}
