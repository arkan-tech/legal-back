<?php

namespace App\Http\Tasks\Merged\Auth\Register;

use App\Http\Requests\CheckPhoneRequest;
use App\Http\Tasks\BaseTask;
use App\Models\AccountsOtp;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Mail;
use App\Models\Lawyer\LawyerFirstStepVerefication;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;

class ConfirmPhoneTask extends BaseTask
{
    public function run(Request $request)
    {
        $currentCode = AccountsOtp::where(['phone_code' => $request->phone_code, 'phone' => $request->phone, 'otp' => $request->otp])->first();
        if (!is_null($currentCode)) {
            if ($currentCode->confirmed == 1) {
                return $this->sendResponse(false, 'تم التفعيل بالفعل', null, 409);
            } else {
                if ($currentCode->expires_at >= now()) {
                    $currentCode->update([
                        'confirmed' => 1
                    ]);
                    $msg = "تم تأكيد رقم الهاتف بنجاح";
                    return $this->sendResponse(true, $msg, null, 200);
                }
            }
        }
        $msg = 'رمز التأكيد خطأ';
        return $this->sendResponse(false, $msg, null, 400);
    }
}
