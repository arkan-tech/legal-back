<?php

namespace App\Http\Tasks\Merged\Auth\Register;

use App\Models\AppTexts;
use GuzzleHttp\Client;
use App\Models\Account;
use App\Models\Activity;
use App\Models\LawyerOld;
use App\Models\Newsletter;
use App\Models\AccountsOtp;
use App\Http\Tasks\BaseTask;
use App\Models\Gamification;
use App\Models\ReferralCode;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\ServiceUserOld;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AccountResource;
use App\Http\Requests\CheckPhoneRequest;
use App\Http\Requests\RegisterAccountRequest;
use App\Models\Lawyer\LawyerFirstStepVerefication;
use App\Http\Requests\API\Merged\AccountLoginRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;

class LoginAccountTask extends BaseTask
{
    public function run(AccountLoginRequest $request)
    {
        $account = Account::where('email', $request->email)->first();
        if (is_null($account)) {
            return $this->sendResponse(false, 'خطأ في الهاتف أو كلمة المرور', null, 401);
        }
        $token = auth()->guard('api_account')->attempt(
            ['email' => $request->email, 'password' => $request->password]
        );
        if (!$token) {
            return $this->sendResponse(false, 'خطأ في الهاتف أو كلمة المرور', null, 401);
        }

        if ($account->status == 0) {
            return $this->sendResponse(false, AppTexts::where('key', 'account-blocked')->first()->value, null, 403);
        }
        if ($account->status == 1) {
            $msg = AppTexts::where('key', 'account-new')->first()->value;
        }
        if ($account->status == 2) {
            $msg = AppTexts::where('key', 'account-accepted')->first()->value;
        }
        if ($account->status == 3) {
            $msg = AppTexts::where('key', operator: 'account-pending')->first()->value;
        }
        $key = GenerateRegistrationRandomCode(6);
        if ($account->email_confirmation != 1) {
            $bodyMessage3 = '';
            $bodyMessage4 = '';
            $bodyMessage5 = '';
            $bodyMessage6 = '';
            $bodyMessage7 = 'للتواصل والدعم الفني :';
            $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage9 = '';
            $bodyMessage10 = 'نعتز بثقتكم';
            $bodyMessage = nl2br(AppTexts::where('key', 'confirm-email-link')->first()->value);
            $em_data = [
                'name' => $account->name,
                'email' => $account->email,
                'subject' => "رابط تأكيد البريد . ",
                'bodyMessage' => $bodyMessage,
                'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
                'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
                'bodyMessage3' => env('REACT_WEB_LINK') . '/auth/confirmEmail?otp=' . $key . '&id=' . $account->id . '&type=account',
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
            $account->update([
                'email_otp' => $key,
                'email_otp_expires_at' => now()->addMinutes(3)
            ]);
            $msg = 'تم إرسال رابط تأكيد البريد الإلكتروني على بريدكم بنجاح.
            نأمل تأكيد البريد بالضغط على الرابط المرسل لكم.';
        } else if ($account->phone_confirmation != 1 && $account->phone_code == 966) {
            $username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
            $password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
            $destinations = $account->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
            $message = 'كود تفعيل الحساب : ' . ' ' . $key;      // محتوى الرسالة
            $message = urlencode($message);
            $sender = "Ymtaz.sa";         // اسم المرسل الخاص بك المفعل  في الموقع
            $url = "http://www.jawalbsms.ws/api.php/sendsms?user=$username&pass=$password&to=$destinations&message=$message&sender=$sender&unicode=u";
            \Illuminate\Support\Facades\Log::info($url);
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(),
                )
            );
            $response = curl_exec($curl);
            \Illuminate\Support\Facades\Log::info($response);
            curl_close($curl);
            $account->update([
                'phone_otp' => $key,
                'phone_otp_expires_at' => now()->addMinutes(3)
            ]);
        }
        // $httpClient = new Client();
        // $jsonData = [
        //     "userId" => $account->id
        // ];
        // $httpRequest = $httpClient->postAsync(env('JS_API_URL') . 'get-stream/createToken', [
        //     'json' => $jsonData
        // ]);
        // $httpRequest->wait();
        $token = JWTAuth::fromUser($account);
        $account->injectToken($token);

        $account = Account::find($account->id);
        $token = JWTAuth::fromUser($account);
        $account->injectToken($token);
        $account = new AccountResource($account);
        return $this->sendResponse(true, $msg, compact('account'), 200);
    }
}