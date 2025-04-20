<?php

namespace App\Http\Tasks\Lawyer\Auth\Login;

use GuzzleHttp\Client;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Requests\API\Lawyer\Auth\Login\LawyerLoginRequest;

class LawyerLoginTask extends BaseTask
{
    public function run(LawyerLoginRequest $request)
    {

        $lawyer = Lawyer::where('phone', $request->credential1)->orWhere('email', $request->credential1)->first();
        if (is_null($lawyer)) {
            return $this->sendResponse(false, 'خطأ في الهاتف أو كلمة المرور', null, 401);
        }
        $credentials = request(['credential1', 'password']);
        $token = auth()->guard('api_lawyer')->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
        if (!$token) {
            return $this->sendResponse(false, 'خطأ في الهاتف أو كلمة المرور', null, 401);

        }

        if ($lawyer->accepted == 0) {
            return $this->sendResponse(false, "لقد تم تعليق حسابكم في يمتاز بناء على طلبكم أو لسبب قررته الإدارة المختصة.
يمكنك التواصل معنا في حال كان هذا التعليق خاطئاً أو غير مبرر.", null, 403);
        }
        if ($lawyer->accepted == 1) {
            $msg = "  حسابكم الآن بمنصة يمتاز الإلكترونية في حالة قيد الدراسة والتفعيل، وسيصلكم الإشعار بتفعيل عضويتكم أو طلب تحديث بياناتكم قريبا.";
        }
        if ($lawyer->accepted == 2) {
            $msg = "تهانينا ,لقد تم تفعيل حسابكم بمنصة يمتاز القانونية بنجاح.
    يمكنكم الآن الاطلاع على ملفكم الشخصي والتمتع بخصائص عضويتكم بكل يسر وسهولة.";
        }
        if ($lawyer->accepted == 3) {
            $msg = "شريكنا العزيز:
يمكنك الآن تحديث بياناتك للحصول على مزايا العضوية التي تخولك الاستفادة من المزايا المجانية.";
        }

        $key = GenerateRegistrationRandomCode(6);

        if (!is_null($lawyer->confirmationType)) {
            if ($lawyer->confirmationType == "email") {
                $bodyMessage3 = '';
                $bodyMessage4 = '';
                $bodyMessage5 = '';
                $bodyMessage6 = '';
                $bodyMessage7 = 'للتواصل والدعم الفني :';
                $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
                $bodyMessage9 = '';
                $bodyMessage10 = 'نعتز بثقتكم';
                $em_data = [
                    'name' => $lawyer->myname,
                    'email' => $lawyer->email,
                    'subject' => " كود تفعيل الحساب . ",
                    'bodyMessage' => "مرحباً بك في تطبيق يمتاز , كود التفعيل الذي يمكنك تفعيل حسابك حتى تستمتع بخدمات التطبيق : ",
                    'bodyMessage1' => $key,
                    'bodyMessage2' => " ",
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
                Mail::send(
                    'email',
                    $em_data,
                    function ($message) use ($em_data) {
                        $message->from('ymtaz@ymtaz.sa');
                        $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
                    }
                );
            } else {
                $username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
                $password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
                $destinations = $lawyer->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
                $message = 'كود تفعيل الحساب : ' . ' ' . $key;      // محتوى الرسالة
                $message = urlencode($message);
                $sender = "Ymtaz.sa";         // اسم المرسل الخاص بك المفعل  في الموقع
                $url = "http://www.jawalbsms.ws/api.php/sendsms?user=$username&pass=$password&to=$destinations&message=$message&sender=$sender&unicode=u";
                \Log::info($url);
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
                \Log::info($response);
                curl_close($curl);
            }
            $lawyer->update([
                'confirmationOtp' => $key
            ]);
        }
        if ($lawyer->activate_email_otp) {

            $activate_email_otp = GenerateRegistrationRandomCode(6);
            $lawyer->update([
                'activate_email_otp' => $activate_email_otp
            ]);
            $bodyMessage4 = 'لتسجيل الدخول ';
            $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage6 = 'لاستعادة كلمة المرور :';
            // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=lawyer";
            $bodyMessage6 = "";
            $bodyMessage7 = "";
            $bodyMessage8 = 'للتواصل والدعم الفني :';
            $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage10 = 'نعتز بثقتكم';
            $em_data = [
                'name' => $lawyer->name,
                'email' => $lawyer->email,
                'subject' => "رابط تأكيد البريد . ",
                'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز واكتمال طلب التفعيل .  ",
                'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
                'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
                'bodyMessage3' => env('REACT_WEB_LINK') . '/auth/confirmOtpLawyer?otp=' . $activate_email_otp . '&id=' . $lawyer->id,
                'bodyMessage4' => $bodyMessage4,
                'bodyMessage5' => $bodyMessage5,
                'bodyMessage6' => $bodyMessage6,
                'bodyMessage7' => $bodyMessage7,
                'bodyMessage8' => $bodyMessage8,
                'bodyMessage9' => $bodyMessage9,
                'bodyMessage10' => $bodyMessage10,
                'platformLink' => env('REACT_WEB_LINK'),
            ];
            Mail::send(
                'email',
                $em_data,
                function ($message) use ($em_data) {
                    $message->from('ymtaz@ymtaz.sa');
                    $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
                }
            );
            $msg = "لم يتم تأكيد بريدكم الإلكتروني حتى الأن
يرجى منكم مراجعة بريدك الإلكتروني مجدداً لتفعيل حسابكم";
        }
        $httpClient = new Client();
        $jsonData = [
            "userType" => "lawyer",
            "userId" => $lawyer->id
        ];
        $httpRequest = $httpClient->postAsync(env('JS_API_URL') . 'get-stream/createToken', [
            'json' => $jsonData
        ]);
        $httpRequest->wait();
        if (is_null($lawyer->referralCode)) {
            $referralCode = GenerateReferralCode();
            $lawyer->referralCode()->create([
                'referral_code' => $referralCode
            ]);
        }
        $lawyer = Lawyer::where('phone', $request->credential1)->orWhere('email', $request->credential1)->first();
        $token = JWTAuth::fromUser($lawyer);
        $lawyer->injectToken($token);
        $lawyer = new LawyerShortDataResource($lawyer);
        return $this->sendResponse(true, $msg, compact('lawyer'), 200);

    }

    protected function credentials(Request $request)
    {

        if (is_numeric($request->get('credential1'))) {
            return ['phone' => $request->get('credential1'), 'password' => $request->get('password')];
        } elseif (filter_var($request->get('credential1'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('credential1'), 'password' => $request->get('password')];
        }
        return ['email' => $request->get('credential1'), 'password' => $request->get('password')];
    }
}
