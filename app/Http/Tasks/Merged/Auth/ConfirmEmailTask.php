<?php

namespace App\Http\Tasks\Merged\Auth;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AccountResource;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;

class ConfirmEmailTask extends BaseTask
{
    public function run(Request $request)
    {

        $user = Account::find($request->id);
        if (is_null($user)) {
            return $this->sendResponse(false, 'الرمز خطأ', null, 400);
        }
        if ($user->email_confirmation == 0) {
            if ($user->email_otp != $request->key) {
                return $this->sendResponse(false, 'الرمز خطأ', null, 400);
            }

            if ($user->status == 2) {
                $user->update([
                    'email_confirmation' => 1,
                    'email_otp' => null,
                    'email_otp_expires_at' => null
                ]);

                $msg = "تم تأكيد البريد الإلكتروني بنجاح";
            } else if ($user->status == 3) {
                if ($user->account_type == "lawyer") {
                    $user->update([
                        'email_confirmation' => 1,
                        'email_otp' => null,
                        'email_otp_expires_at' => null
                    ]);
                } else {
                    $user->update([
                        'email_confirmation' => 1,
                        'email_otp' => null,
                        'email_otp_expires_at' => null
                    ]);
                }

                $msg = "تم تأكيد البريد الإلكتروني بنجاح";
                $user = new AccountResource($user);
            } else {
                $user->update([
                    'email_confirmation' => 1,
                    'email_otp' => null,
                    'email_otp_expires_at' => null
                ]);
                $msg="??";
            }

            return $this->sendResponse(
                true,
                $msg,
                $user,
                200,
            );
        } else {
            return $this->sendResponse(false, 'تم تأكيد الحساب بالفعل', null, 400);
        }

    }
}
