<?php

namespace App\Http\Tasks\Client\Auth\Password;

use App\Http\Requests\API\Client\Auth\Password\ClientResetPasswordRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Tasks\BaseTask;
use App\Models\Service\ServiceUser;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClientResetPasswordTask extends BaseTask
{

    public function run(ClientResetPasswordRequest $request)
    {
        $client = ServiceUser::where('pass_code', $request->code)->where('pass_reset', 1)->first();
        if (!$client) {
            return $this->sendResponse(false, 'رمز التحقق غير صالح', null, 422);
        }
        $client->update([
            'pass_code' => null,
            'pass_reset' => 0,
            'password' => bcrypt($request->password),
        ]);
        $token = JWTAuth::fromUser($client);
        $client->injectToken($token);
        $client = new ClientDataResource($client);
        return $this->sendResponse(true, 'تم تعديل كلمة المرور بنجاح', compact('client'), 200);

    }

}
