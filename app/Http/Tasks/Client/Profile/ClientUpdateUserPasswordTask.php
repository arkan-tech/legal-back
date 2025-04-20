<?php

namespace App\Http\Tasks\Client\Profile;

use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Tasks\BaseTask;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClientUpdateUserPasswordTask extends BaseTask
{

    public function run(ClientUpdateUserPasswordRequest $request)
    {
        $hashedPassword = $this->authClient()->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                $client = ServiceUser::find($this->authClient()->id);
                $client->update(['password' => bcrypt($request->password)]);
                $token = JWTAuth::fromUser($client);
                $client->injectToken($token);
                $client = new ClientDataResource($client);
                return $this->sendResponse(true, 'تم تحديث كلمة المرور', compact('client'), 200);
            } else {
                return $this->sendResponse(true, 'كلمة المرور الجديدة يجب ان لا تكون مطابقة لكلمة المرور القديمة!', null, 200);

            }
        } else {
            return $this->sendResponse(true, 'كلمة المرور القديمة غير صحيحة ', null, 200);
        }


    }
}
