<?php

namespace App\Http\Tasks\Merged\Auth\Register;

use App\Models\Account;
use App\Models\AccountInvites;
use App\Models\Activity;
use App\Models\AppTexts;
use App\Models\LawyerOld;
use App\Models\Newsletter;
use App\Models\AccountsOtp;
use App\Http\Tasks\BaseTask;
use App\Models\Gamification;
use App\Models\ReferralCode;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\ServiceUserOld;
use App\Models\Service\ServiceUser;
use App\Models\LawyerAdditionalInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CheckPhoneRequest;
use App\Http\Requests\RegisterAccountRequest;
use App\Models\Lawyer\LawyerFirstStepVerefication;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;

class RegisterAccountTask extends BaseTask
{
    public function run(RegisterAccountRequest $request)
    {
        $name = $request->account_type == "lawyer" ? implode(" ", array_filter([
            $request->first_name ?? '',
            $request->second_name ?? '',
            $request->third_name ?? '',
            $request->fourth_name ?? '',
        ])) : $request->name;
        $referralCode = GenerateReferralCode();
        if ($request->phone_code == "966") {
            $currentCode = AccountsOtp::where(['phone_code' => $request->phone_code, 'phone' => $request->phone, 'otp' => $request->otp])->first();
            if ($currentCode) {
                if (!$currentCode->confirmed) {
                    return $this->sendResponse(false, 'لم يتم تأكيد رمز التحقق', null, 400);
                }
            } else {
                return $this->sendResponse(false, 'رمز التحقق غير صحيح', null, 400);
            }
            $currentCode->delete();
        }
        $key = GenerateRegistrationRandomCode(6);
        $isLawyer = $request->account_type == "lawyer";
        $account1 = ServiceUser::create([
            'myname' => $name,
            'phone_code' => $request->phone_code,
            'mobil' => $request->phone,
            'type' => $request->account_type === 'client' ? 1 : 2,
            'email' => $request->email,
            // 'active' => 0,
            'status' => 1,
            // 'activation_type' => $request->activation_type,
            // 'nationality_id' => $request->nationality_id,
            // 'country_id' => $request->country_id,
            // 'city_id' => $request->city_id,
            // 'region_id' => $request->region_id,
            // 'longitude' => $request->longitude,
            // 'latitude' => $request->latitude,
            'gender' => $request->gender,
            'accepted' => 1,
            'active_otp' => $key,
            'password' => bcrypt($request->password),
            'referred_by' => $request->referal_code ?? null,
            'level_id' => 1,
            'rank_id' => 1,

        ]);
        $account = Account::create([
            'id' => $account1->id,
            'name' => $name,
            'email' => $request->email,
            'phone' => $request->phone,
            'phone_code' => $request->phone_code,
            'password' => bcrypt($request->password),
            'referred_by' => $request->referal_code ?? null,
            'account_type' => $request->account_type,
            'status' => 1,
            'profile_complete' => 0,
            'phone_confirmation' => 1,
            'phone_verified_at' => now(),
            'email_otp' => $key,
            'gender' => $request->gender
        ]);


        Gamification::create([
            'account_id' => $account->id,
            'gamification_type' => "client",
            'level_id' => 1,
            'rank_id' => 1,
            'streak' => 0,
        ]);
        if ($request->account_type) {
            LawyerAdditionalInfo::create([
                'account_id' => $account->id
            ]);
        }
        $account->referralCode()->create([
            'referral_code' => $referralCode,
        ]);
        $oldUser = ServiceUserOld::where('email', $request->email)->orWhere(function ($query) use ($request) {
            $query->where('mobil', $request->mobile)
                ->where('phone_code', $request->phone_code);
        })->first();
        if (!is_null($oldUser)) {
            if ($oldUser->accepted == 0) {
                $oldUser->update([
                    'accepted' => 1
                ]);
            }
        } else {
            $oldUser = LawyerOld::where('email', $request->email)->orWhere(function ($query) use ($request) {
                $query->where('phone', $request->mobile)
                    ->where('phone_code', $request->phone_code);
            })->first();
            if (!is_null($oldUser)) {
                if ($oldUser->accepted == 0) {
                    $oldUser->update([
                        'accepted' => 1
                    ]);
                }
            }
        }
        if (!is_null($request->referred_by)) {
            $referral = ReferralCode::where('referral_code', $request->referred_by)->first();
            if (!is_null($referral)) {
                $referralUser = $referral->user()->clientGamification();
                $activity = Activity::find(5);
                $referralUser->addExperience($activity->experience_points, $activity->name);
                $account->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);
                $invite = AccountInvites::where('email', $request->email)->orWhere(['phone_code' => $request->phone_code, 'phone' => $request->phone])->first();
                if (!is_null($invite)) {
                    $invite->update([
                        'status' => 2
                    ]);
                }
            }
        }
        $bodyMessage4 = '';
        $bodyMessage5 = '';
        $bodyMessage6 = '';
        $bodyMessage7 = 'للتواصل والدعم الفني :';
        $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
        $bodyMessage9 = '';
        $bodyMessage10 = 'نعتز بثقتكم';
        $bodyMessage = nl2br(AppTexts::where('key', 'confirm-email-link')->first()->value);
        $em_data = [
            'name' => $name,
            'email' => $request->email,
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
        $activity = Activity::find(9);
        $account->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);
        $newsletter = Newsletter::where('email', $request->email);
        if (is_null($newsletter)) {
            Newsletter::create([
                "email" => $request->email
            ]);
        }
        //         $welcomeMessage = "شكراً لتسجيلك في تطبيق يمتاز, ربحت معنا ٥٠ نقطة في حسابك.
        // باستكمال ملفك ستكسب ١٠٠ نقطة إضافية وبالدخول اليومي ستربح ١٠ نقاط جديدة.";
        $welcomeMessage = AppTexts::where('key', 'welcome-message-sms')->first()->value;
        if ($account->phone_code == "966") {

            $username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
            $password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
            $destinations = $account->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
            $message = $welcomeMessage;
            $message = urlencode($message);
            $sender = "Ymtaz.sa";         // اسم المرسل الخاص بك المفعل  في الموقع
            $url = "http://www.jawalbsms.ws/api.php/sendsms?user=$username&pass=$password&to=$destinations&message=$message&sender=$sender";
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
        }
        $msg = 'تم إرسال رابط تأكيد البريد الإلكتروني على بريدكم بنجاح.
نأمل تأكيد البريد بالضغط على الرابط المرسل لكم.';

// dd($account,$account1);
        return $this->sendResponse(true, $msg, null, 200);
    }
}
