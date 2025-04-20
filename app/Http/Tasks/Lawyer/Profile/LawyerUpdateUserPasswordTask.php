<?php

namespace App\Http\Tasks\Lawyer\Profile;

use App\Http\Requests\API\Lawyer\Profile\LawyerUpdateUserPasswordRequest;
use App\Http\Requests\API\Lawyer\Profile\LawyerUpdateUserProfileRequest;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LawyerUpdateUserPasswordTask extends BaseTask
{

    public function run(LawyerUpdateUserPasswordRequest $request)
    {
        $hashedPassword = $this->authLawyer()->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                $lawyer = Lawyer::find($this->authLawyer()->id);
                $lawyer->update(['password' => bcrypt($request->password)]);
                $token = JWTAuth::fromUser($lawyer);
                $lawyer->injectToken($token);
                $lawyer = new LawyerDataResource($lawyer);
                return $this->sendResponse(true, 'تم تحديث كلمة المرور', compact('lawyer'), 200);
            } else {
                return $this->sendResponse(true, 'كلمة المرور الجديدة يجب ان لا تكون مطابقة لكلمة المرور القديمة!', null, 200);

            }
        } else {
            return $this->sendResponse(true, 'كلمة المرور القديمة غير صحيحة ', null, 200);
        }


    }
}
