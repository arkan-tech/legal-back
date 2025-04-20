<?php

namespace App\Http\Tasks\Merged\Auth;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Mail;

class ResendConfirmationOtp extends BaseTask
{
	public function run(Request $request)
	{
		$user = auth()->user();
		$reserverType = "lawyer";
		$key = GenerateRegistrationRandomCode(6);
		$sendOtp = true;
		if (auth()->guard('api_lawyer')->check()) {
			$reserverType = "lawyer";
			$user = Lawyer::find($user->id);
			if (!is_null($user->confirmationType)) {
				if ($user->confirmationType == "email") {
					$bodyMessage3 = '';
					$bodyMessage4 = '';
					$bodyMessage5 = '';
					$bodyMessage6 = '';
					$bodyMessage7 = 'للتواصل والدعم الفني :';
					$bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
					$bodyMessage9 = '';
					$bodyMessage10 = 'نعتز بثقتكم';
					$em_data = [
						'name' => $user->myname,
						'email' => $user->email,
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
					if ($user->phone_code != 966) {
						$sendOtp = false;
					}
					$username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
					$password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
					$destinations = $user->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
				if ($sendOtp) {
					$user->update([
						'confirmationOtp' => $key
					]);
				}
			} else {
				$sendOtp = false;
			}
			$user = new LawyerShortDataResource($user);
		}
		if (auth()->guard('api_client')->check()) {
			$reserverType = "client";
			$user = ServiceUser::find($user->id);
			if ($user->active == 0) {
				if ($user->activation_type == 1) {
					$bodyMessage3 = '';
					$bodyMessage4 = '';
					$bodyMessage5 = '';
					$bodyMessage6 = '';
					$bodyMessage7 = 'للتواصل والدعم الفني :';
					$bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
					$bodyMessage9 = '';
					$bodyMessage10 = 'نعتز بثقتكم';
					$em_data = [
						'name' => $user->myname,
						'email' => $user->email,
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
					if ($user->phone_code != 966) {
						$sendOtp = false;
					}
					$username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
					$password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
					$destinations = $user->mobil; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
				if ($sendOtp) {
					$user->update([
						'active_otp' => $key
					]);
				}
			} else if (!is_null($user->confirmationType)) {
				if ($user->confirmationType == "email") {
					$bodyMessage3 = '';
					$bodyMessage4 = '';
					$bodyMessage5 = '';
					$bodyMessage6 = '';
					$bodyMessage7 = 'للتواصل والدعم الفني :';
					$bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
					$bodyMessage9 = '';
					$bodyMessage10 = 'نعتز بثقتكم';
					$em_data = [
						'name' => $user->myname,
						'email' => $user->email,
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
					$destinations = $user->mobil; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
				$user->update([
					'confirmationOtp' => $key
				]);

			} else {
				$sendOtp = false;
			}
			$user = new ClientDataResource($user);
		}
		if ($sendOtp) {

			return $this->sendResponse(true, "تم إرسال رمز التحقق مرة أخرى", $user, 200);
		} else {
			return $this->sendResponse(false, 'لا يوجد رمز تحقق', null, 400);
		}

	}
}
