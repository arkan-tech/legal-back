<?php

namespace App\Http\Tasks\Merged\Auth\Password;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\ResetPassword;
use App\Http\Requests\CheckForgetPasswordTokenRequest;

class ForgotPasswordVerificationTask extends BaseTask
{
    public function run(CheckForgetPasswordTokenRequest $request)
    {
        $resetPassword = ResetPassword::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetPassword || $resetPassword->expires_at->isPast()) {
            return $this->sendResponse(false, 'رمز التحقق غير صالح', null, 400);
        }

        return $this->sendResponse(true, 'تم التحقق , توجه الى تغيير كلمة المرور', null, 200);
    }
}
