<?php

namespace App\Http\Tasks\Client\Auth\Password;

use App\Http\Requests\API\Client\Auth\Password\ClientForgotPasswordVerificationRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Service\ServiceUser;

class ClientForgotPasswordVerificationTask extends BaseTask
{
    public function run(ClientForgotPasswordVerificationRequest $request)
    {
        $client = ServiceUser::where('pass_code',$request->code)->where('pass_reset',1)->first();
        if (is_null($client)){
            return $this->sendResponse(false, 'رمز التحقق غير صالح', null, 422);
        }else{
//            $client->update([
//                'pass_code' => null,
//                'pass_reset' => 0,
//            ]);
            $pass_code= $client->pass_code;
            return $this->sendResponse(true, 'تم التحقق , توجه الى تغيير كلمة المرور', compact('pass_code'), 200);

        }

    }
}
