<?php

namespace App\Http\Tasks\Merged\Auth\Password;

use App\Http\Requests\ResetPasswordRequest;
use Hash;
use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\ResetPassword;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\AccountResource;

class ChangePasswordTask extends BaseTask
{

    public function run(ResetPasswordRequest $request)
    {

        $resetPassword = ResetPassword::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetPassword || $resetPassword->expires_at->isPast() || $resetPassword->used) {
            return $this->sendResponse(false, 'رمز التحقق غير صالح', null, 400);
        }

        // Mark token as used
        $resetPassword->update(['used' => true]);

        // Update the password in the accounts table
        $account = Account::where('email', $request->email)->first();
        $account->update(['password' => Hash::make($request->password)]);
        $token = JWTAuth::fromUser($account);
        $account->injectToken($token);
        $account = new AccountResource($account);
        return $this->sendResponse(true, 'تم تعديل كلمة المرور بنجاح', compact('account'), 200);


    }

}
