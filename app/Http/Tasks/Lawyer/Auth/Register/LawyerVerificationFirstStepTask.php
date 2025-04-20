<?php

namespace App\Http\Tasks\Lawyer\Auth\Register;

use App\Http\Requests\API\Lawyer\Auth\Register\LawyerRegisterRequest;
use App\Http\Requests\API\Lawyer\Auth\Register\LawyerVerificationFirstStepRequest;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Tasks\BaseTask;
use App\Models\Degree\Degree;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyerFirstStepVerefication;
use App\Models\Lawyer\LawyerSections;
use App\Models\Service\ServiceUser;
use Tymon\JWTAuth\Facades\JWTAuth;
use Mail;

class LawyerVerificationFirstStepTask extends BaseTask
{
	public function run(LawyerVerificationFirstStepRequest $request)
	{
		$phone = $request->phone;
		$check = Lawyer::where('phone', $phone)->first();
		if (!is_null($check)) {
			return $this->sendResponse(false, 'رقم الجوال موجود مسبقاً ', null, 422);
		}
		$phone_code = $request->phone_code;
		$key = GenerateRegistrationRandomCode(6);
		LawyerFirstStepVerefication::create([
			'email' => $request->email,
			'phone_code' => $request->phone_code,
			'phone' => $request->phone,
			'otp' => $key,
		]);
		if ($phone_code == 966) {
			$username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
			$password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
			$destinations = $request->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
			$message = 'كود تفعيل الحساب : ' . ' ' . $key;      // محتوى الرسالة
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
			curl_close($curl);
			$msg = 'تم ارسال كود التفعيل على SMS , نرجو مراجعة هاتفك حتي يمكنك تفعيل حسابك ,';
		} else {
			$bodyMessage3 = '';
			$bodyMessage4 = '';
			$bodyMessage5 = '';
			$bodyMessage6 = '';
			$bodyMessage7 = 'للتواصل والدعم الفني :';
			$bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
			$bodyMessage9 = '';
			$bodyMessage10 = 'نعتز بثقتكم';
			$em_data = [
				'name' => '',
				'email' => $request->email,
				'subject' => " كود تأكيد  . ",
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
			$msg = 'تم ارسال كود التفعيل على الايميل , نرجو مراجعة الايميل حتي يمكنك تفعيل حسابك ,';
		}
		return $this->sendResponse(true, $msg, null, 200);

	}

}
