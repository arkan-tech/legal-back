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

class CheckPhoneTask extends BaseTask
{
    public function run(CheckPhoneRequest $request)
    {
        $previousCodes = AccountsOtp::where(['phone_code' => $request->phone_code, 'phone' => $request->phone])->get();
        if ($previousCodes->count() > 0) {
            $previousCodes->each(function ($q) {
                $q->delete();
            });
        }
        $key = GenerateRegistrationRandomCode(6);
        $username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
        $password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
        $destinations = $request->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
        $msg = 'تم ارسال كود التأكيد على SMS , نرجو مراجعة هاتفك حتي يمكنك تأكيد رقمك ,';
        AccountsOtp::create([
            'phone_code' => $request->phone_code,
            'phone' => $request->phone,
            'otp' => $key,
            'expires_at' => now()->addMinutes(3)
        ]);
        return $this->sendResponse(true, $msg, null, 200);
    }
}
