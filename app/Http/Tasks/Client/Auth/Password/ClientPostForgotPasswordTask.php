<?php

namespace App\Http\Tasks\Client\Auth\Password;

use App\Http\Requests\API\Client\Auth\Password\ClientPostForgotPasswordRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Service\ServiceUser;
use Mail;

class ClientPostForgotPasswordTask extends BaseTask
{
	public function run(ClientPostForgotPasswordRequest $request)
	{
		if ($request->type == 1) {
			$client = ServiceUser::where('email', $request->credential)->first();
			if (!$client) {
				return $this->sendResponse(false, 'خطأ في الجوال , نرجو اضافة رقم الجوال الذي تم استخدامه في التسجيل حتى نتمكن من ارسال عليه كود التحقق ', null, 422);
			} else {
				$key = rand(1231, 7879);
				$client->update([
					'pass_code' => $key,
					'pass_reset' => 1,
				]);
				$bodyMessage3 = '';
				$bodyMessage4 = 'لتسجيل الدخول ';
				$bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
				$bodyMessage6 = '';
				$bodyMessage7 = 'للتواصل والدعم الفني :';
				$bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
				$bodyMessage9 = '';
				$bodyMessage10 = 'نعتز بثقتكم';
				$em_data = [
					'name' => $client->myname,
					'email' => $client->email,
					'subject' => " استعادة كلمة المرور الخاصة بك ",
					'bodyMessage' => "من فضلك قم باستخدام هذا الكود لاستعادة كلمة المرور الخاصة بك في تطبيق الموبايل: ",
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

				return $this->sendResponse(true, 'تم ارسال رمز التحقق  , يرجى تفقد بريدك الالكتروني حتى تستطيع استرجاع كلمة المرور ', null, 200);

			}
		} else {
			$client = ServiceUser::where('mobil', $request->credential)->first();
			if (!$client) {
				return $this->sendResponse(false, 'خطأ في الايميل , نرجو اضافة الايميل الذي تم استخدامه حتى نتمكن من ارسال عليه كود التحقق ', null, 422);
			} else {
				$key = rand(1231, 7879);
				$client->update([
					'pass_code' => $key,
					'pass_reset' => 1,
				]);

				$username = "Ymtaz.sa";		    // اسم المستخدم الخاص بك في الموقع
				$password = urlencode("Ymtaz@132@132@132"); 		// كلمة المرور الخاصة بك
				$destinations = $client->mobil; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
				$message = 'من فضلك قم باستخدام هذا الكود' . ' ' . $key . ' ' . ' لاستعادة كلمة المرور الخاصة بك في تطبيق الموبايل ';      // محتوى الرسالة
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
				return $this->sendResponse(true, 'تم ارسال رمز التحقق  , يرجى تفقد بريدك الالكتروني حتى تستطيع استرجاع كلمة المرور ', null, 200);
			}
		}
	}
}
