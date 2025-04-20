<?php

namespace App\Http\Tasks\Client\Auth\Register;

use App\Http\Requests\API\Client\Auth\Register\ClientActivateAccountRequest;
use App\Http\Requests\API\Client\Auth\Register\ClientRegisterRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Tasks\BaseTask;
use App\Models\Service\ServiceUser;
use Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClientActivateAccountTask extends BaseTask
{
	public function run(ClientActivateAccountRequest $request)
	{
		$client = ServiceUser::where('id', $request->client_id)->first();
		if (is_null($client)) {
			return $this->sendResponse(false, 'الحساب غير موجود', null, 404);
		}
		if ($client->active_otp != $request->otp_code) {
			return $this->sendResponse(false, 'كود التحقق غير صحيح', null, 400);
		}

		if ($client->phone_code == 966) {
			$key = GenerateRegistrationRandomCode(6);
			$link = env('REACT_WEB_LINK') . "/auth/confirmOtp?otp=" . $key . "&clientId=" . $client->id;
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
				'subject' => "رابط تأكيد البريد  . ",
				'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز . ",
				'bodyMessage1' => 'يرجى اتباع الرابط التالي : ',
				'bodyMessage2' => $link,
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
			$client->update([
				'active_otp' => $key,
			]);
			$client = new ClientDataResource($client);
			return $this->sendResponse(true, 'تم تفعيل الرقم بنجاح
نأمل منكم تأكيد التفعيل بالضغط على الرابط المرسل لكم على بريدكم الإلكتروني المسجل لدينا
', compact('client'), 200);

		} else {
			$client->update([
				'active' => 1,
				'accepted' => 2,
				'active_otp' => null,
			]);
			$token = JWTAuth::fromUser($client);
			$client->injectToken($token);
			$client = new ClientDataResource($client);
			return $this->sendResponse(true, 'تم تفعيل الحساب بنجاح', compact('client'), 200);
		}


	}

}
