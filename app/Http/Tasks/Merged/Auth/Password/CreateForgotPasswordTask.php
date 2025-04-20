<?php

namespace App\Http\Tasks\Merged\Auth\Password;

use Mail;
use Carbon\Carbon;
use App\Models\Account;
use App\Models\AppTexts;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\ResetPassword;
use App\Http\Requests\ForgetPasswordRequest;

class CreateForgotPasswordTask extends BaseTask
{
    public function run(ForgetPasswordRequest $request)
    {

        $token = GenerateRegistrationRandomCode();

        ResetPassword::create([
            'email' => $request->email,
            'token' => $token,
            'expires_at' => Carbon::now()->addMinutes(3), // Expire in 3 minutes
        ]);
        $account = Account::where('email', $request->email)->first();
        $bodyMessage3 = '';
        $bodyMessage4 = "";
        $bodyMessage5 = "";
        $bodyMessage6 = '';
        $bodyMessage7 = "";
        $bodyMessage8 = "";
        $bodyMessage9 = '';
        $bodyMessage10 = 'نعتز بثقتكم';
        $bodyMessage = nl2br(AppTexts::where('key', 'forget-password-email-message')->first()->value);

        $em_data = [
            'name' => $account->name,
            'email' => $account->email,
            'subject' => " استعادة كلمة المرور الخاصة بك ",
            'bodyMessage' => $bodyMessage,
            'bodyMessage1' => $token,
            'bodyMessage2' => "",
            'bodyMessage3' => $bodyMessage3,
            'bodyMessage4' => $bodyMessage4,
            'bodyMessage5' => $bodyMessage5,
            'bodyMessage6' => $bodyMessage6,
            'bodyMessage7' => $bodyMessage7,
            'bodyMessage8' => $bodyMessage8,
            'bodyMessage9' => $bodyMessage9,
            'bodyMessage10' => $bodyMessage10,
            'platformLink' => env('REACT_WEB_LINK'),

        ];
        // Mail::send(
        //     'email',
        //     $em_data,
        //     function ($message) use ($em_data) {
        //         $message->from('ymtaz@ymtaz.sa');
        //         $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
        //     }
        // );

        return $this->sendResponse(true, 'تم ارسال رمز التحقق  , يرجى تفقد بريدك الالكتروني حتى تستطيع استرجاع كلمة المرور ', null, 200);


    }
}