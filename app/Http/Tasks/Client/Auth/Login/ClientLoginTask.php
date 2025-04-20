<?php

namespace App\Http\Tasks\Client\Auth\Login;

use App\Models\Account;
use GuzzleHttp\Client;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Requests\API\Client\Auth\Login\ClientLoginRequest;

class ClientLoginTask extends BaseTask
{
	public function run(ClientLoginRequest $request)
	{
		$client = ServiceUser::where('mobil', $request->credential1)->orWhere('email', $request->credential1)->first();
		if (is_null($client)) {
			return $this->sendResponse(false, 'خطأ في الهاتف أو كلمة المرور', null, 401);
		}
		$credentials = request(['credential1', 'password']);
		$token = auth()->guard('api_client')->attempt(
			$this->ClientCredentials($request),
			$request->filled('remember')
		);
		if (!$token) {
			return $this->sendResponse(false, 'خطأ في الهاتف أو كلمة المرور', null, 401);

		}

		if ($client->accepted == 0) {
			return $this->sendResponse(false, "لقد تم تعليق حسابكم في يمتاز بناء على طلبكم أو لسبب قررته الإدارة المختصة.
يمكنك التواصل معنا في حال كان هذا التعليق خاطئاً أو غير مبرر.", null, 403);
		}
		if ($client->accepted == 1) {
			$msg = "  حسابكم الآن بمنصة يمتاز الإلكترونية في حالة قيد الدراسة والتفعيل، وسيصلكم الإشعار بتفعيل عضويتكم أو طلب تحديث بياناتكم قريبا.";
		}
		if ($client->accepted == 2) {
			$msg = "تهانينا ,لقد تم تفعيل حسابكم بمنصة يمتاز القانونية بنجاح.
    يمكنكم الآن الاطلاع على ملفكم الشخصي والتمتع بخصائص عضويتكم بكل يسر وسهولة.";
		}
		if ($client->accepted == 3) {
			$msg = "شريكنا العزيز:
يمكنك الآن تحديث بياناتك للحصول على مزايا العضوية التي تخولك الاستفادة من المزايا المجانية.";
		}


		$key = GenerateRegistrationRandomCode(6);

		if ($client->active == 0) {
			if ($client->activation_type == 1) {
				$bodyMessage3 = '';
				$bodyMessage4 = '';
				$bodyMessage5 = '';
				$bodyMessage6 = '';
				$bodyMessage7 = 'للتواصل والدعم الفني :';
				$bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
				$bodyMessage9 = '';
				$bodyMessage10 = 'نعتز بثقتكم';
				$em_data = [
					'name' => $client->myname,
					'email' => $client->email,
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
				$destinations = $client->mobil; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
			}
			$client->update([
				'active_otp' => $key
			]);
		}
		if (!is_null($client->confirmationType)) {
			if ($client->confirmationType == "email") {
				$bodyMessage3 = '';
				$bodyMessage4 = '';
				$bodyMessage5 = '';
				$bodyMessage6 = '';
				$bodyMessage7 = 'للتواصل والدعم الفني :';
				$bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
				$bodyMessage9 = '';
				$bodyMessage10 = 'نعتز بثقتكم';
				$em_data = [
					'name' => $client->myname,
					'email' => $client->email,
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
				$destinations = $client->mobil; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
			}
			$client->update([
				'confirmationOtp' => $key
			]);
		}



		// $httpClient = new Client();
		// $jsonData = [
		// 	"userType" => "client",
		// 	"userId" => $client->id
		// ];
		// $httpRequest = $httpClient->postAsync(env('JS_API_URL') . 'get-stream/createToken', [
		// 	'json' => $jsonData
		// ]);
		// $httpRequest->wait();



		$account = Account::find($client->id);

        $token = JWTAuth::fromUser($account);
        $account->injectToken($token);



		if (is_null($client->referralCode)) {
			$referralCode = GenerateReferralCode();
			$client->referralCode()->create([
				'referral_code' => $referralCode
			]);
		}
		$client = ServiceUser::where('mobil', $request->credential1)->orWhere('email', $request->credential1)->first();
		$token = JWTAuth::fromUser($client);
		$client->injectToken($token);
		$client = new ClientDataResource($client);
		return $this->sendResponse(true, $msg, compact('client'), 200);

	}

	protected function ClientCredentials(Request $request)
	{

		if (is_numeric($request->get('credential1'))) {
			return ['mobil' => $request->get('credential1'), 'password' => $request->get('password')];
		} elseif (filter_var($request->get('credential1'), FILTER_VALIDATE_EMAIL)) {
			return ['email' => $request->get('credential1'), 'password' => $request->get('password')];
		}
		return ['email' => $request->get('credential1'), 'password' => $request->get('password')];
	}

}