<?php

namespace App\Http\Tasks\Client\Auth\Register;

use Mail;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Service\ServiceUser;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Requests\API\Client\Auth\Register\ClientRegisterRequest;
use App\Http\Requests\API\Client\Auth\Register\ClientActivateAccountRequest;

class ClientConfirmOtpTask extends BaseTask
{
    public function run(Request $request)
    {
        $client = ServiceUser::find($request->client_id);
        if (is_null($client)) {
            return $this->sendResponse(true, "الحساب او الكود غلط", null, 400);
        }
        if ($client->active == 1) {
            return $this->sendResponse(
                true,
                "الحساب مفعل بالفعل",
                null,
                400
            );
        }
        if ($client->active_otp == $request->otp_code) {
            $client->active_otp = null;
            $client->active = 1;
            $client->accepted = 2;
            $client->save();
            return $this->sendResponse(true, 'تم تفعيل الحساب بنجاح', compact('client'), 200);
        } else {
            return $this->sendResponse(
                true,
                'الكود غير صحيح',
                null,
                400
            );
        }
    }

}
