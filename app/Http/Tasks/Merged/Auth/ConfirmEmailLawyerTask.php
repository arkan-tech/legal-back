<?php

namespace App\Http\Tasks\Merged\Auth;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Mail;
use App\Models\Lawyer\LawyerFirstStepVerefication;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;

class ConfirmEmailLawyerTask extends BaseTask
{
    public function run(Request $request)
    {

        $lawyer = Lawyer::where('id', $request->id)->first();
        if (is_null($lawyer)) {
            return $this->sendResponse(false, 'الحساب غير موجود', null, 400);
        }
        if (is_null($lawyer->activate_email_otp)) {
            return $this->sendResponse(false, 'الحساب مفعل بالفعل', null, 400);
        }
        if ($lawyer->activate_email_otp != $request->otp) {
            return $this->sendResponse(false, "الرمز خطأ", null, 400);
        }
        $lawyer->update([
            'activate_email' => 1,
            'activate_email_otp' => null
        ]);
        return $this->sendResponse(true, "تم تأكيد البريد الإلكتروني بنجاح", null, 200);

    }
}
