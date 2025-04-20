<?php

namespace App\Http\Tasks\Merged\Invites;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use App\Models\AccountInvites;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\API\Merged\CreateInviteRequest;
use App\Models\Activity;

class CreateInviteTask extends BaseTask
{

    public function run(CreateInviteRequest $request)
    {
        $account = Account::find(auth()->user()->id);
        \Log::info('test');
        $existingInvite = AccountInvites::where('account_id', '=', $account->id)->where(function ($query) use ($request) {
            if ($request->email) {
                $query->where('email', $request->email);
                if ($request->phone && $request->phone_code) {
                    $query->orWhere(['phone' => $request->phone, 'phone_code' => $request->phone_code]);
                }
            } else if ($request->phone && $request->phone_code) {
                $query->where(['phone' => $request->phone, 'phone_code' => $request->phone_code]);
                if ($request->email) {
                    $query->orWhere('email', $request->email);
                }
            }
        })->first();
        if ($existingInvite) {
            // Invite already exists, return error response
            return $this->sendResponse(false, 'تم إنشاء دعوة مسبقاً لهذا الحساب', null, 400);
        }
        AccountInvites::create([
            'account_id' => $account->id,
            'email' => $request->email,
            'phone' => $request->phone,
            'phone_code' => $request->phone_code
        ]);
        //         $msg = "تصلك هذه الدعوة من أحد أصدقائكم بمناسبة الإصدار الأول لتطبيق يمتاز.
// يسعدنا أنه قد وقع الاختيار عليك لتكون إضافة مميزة لتطبيقنا.
// رمز تسجيل صديقكم: " . $account->referralCode->referral_code;
        $referralCode = $account->referralCode->referral_code;
        $msg = "صديقنا العزيز :
تصلك هذه الدعوة بترشيح من صديق بمناسبة الإصدار الأول لتطبيق يمتاز للخدمات والاستشارات القانونية.
رمز الدعوة : $referralCode
لتحميل التطبيق :
https://onelink.to/bb6n4x
نعتز بثقتكم";
        if ($request->email) {
            $bodyMessage3 = 'لتحميل التطبيق :';
            $bodyMessage4 = 'https://onelink.to/bb6n4x';
            $bodyMessage5 = '';
            $bodyMessage6 = '';
            // $bodyMessage7 = 'للتواصل والدعم الفني :';
            // $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage7 = 'نعتز بثقتكم';
            $bodyMessage8 = '';
            $bodyMessage9 = '';
            $bodyMessage10 = '';
            $em_data = [
                'name' => "No Name",
                'email' => $request->email,
                'subject' => "دعوة صديق",
                'bodyMessage' => "صديقنا العزيز :",
                'bodyMessage1' => "تصلك هذه الدعوة بترشيح من صديق بمناسبة الإصدار الأول لتطبيق يمتاز للخدمات والاستشارات القانونية.",
                'bodyMessage2' => "رمز الدعوة : " . $account->referralCode->referral_code,
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
        } else if ($request->phone) {
            $username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
            $password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
            $destinations = $request->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
            $message = $msg;     // محتوى الرسالة
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
        $activity = Activity::find(10);
        $account->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);

        return $this->sendResponse(true, 'تم انشاء الدعوة', null, 200);
    }
}
