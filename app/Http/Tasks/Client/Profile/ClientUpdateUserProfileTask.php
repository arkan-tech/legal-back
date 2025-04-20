<?php

namespace App\Http\Tasks\Client\Profile;

use Mail;
use App\Models\LawyerOld;
use App\Http\Tasks\BaseTask;
use App\Models\ServiceUserOld;
use App\Models\Service\ServiceUser;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;

class ClientUpdateUserProfileTask extends BaseTask
{

	public function run(ClientUpdateUserProfileRequest $request)
	{
		$client = $this->authClient();
		$originalClient = ServiceUser::find($client->id);
		$phone = $request->mobile;
		$check = ServiceUser::where('id', '<>', $client->id)->where('mobil', $phone)->first();
		if (!is_null($check)) {
			return $this->sendResponse(false, 'رقم الجوال موجود مسبقاً ', null, 422);
		}

		$key = GenerateRegistrationRandomCode(6);
		if ($request->has('name') && !is_null($request->name)) {
			$client->update([
				'myname' => $request->name,
			]);

		}
		if (($request->has('email') && !is_null($request->email))) {
			$client->update([
				'email' => $request->email,
			]);
		}

		if (($request->has('mobile') && !is_null($request->mobile))) {
			$client->update([
				'mobil' => $phone,
				'phone_code' => $request->phone_code,
			]);
		}

		if ($request->has('type') && !is_null($request->type)) {
			$client->update([
				'type' => $request->type,
			]);
		}

		if ($request->has('country_id') && !is_null($request->country_id)) {
			$client->update([
				'country_id' => $request->country_id,
			]);
		}

		if ($request->has('city_id') && !is_null($request->city_id)) {
			$client->update([
				'city_id' => $request->city_id,
			]);
		}
		if ($request->has('region_id') && !is_null($request->region_id)) {
			$client->update([
				'region_id' => $request->region_id,
			]);
		}

		if ($request->has('longitude') && !is_null($request->longitude)) {
			$client->update([
				'longitude' => $request->longitude,
			]);
		}

		if ($request->has('latitude') && !is_null($request->latitude)) {
			$client->update([
				'latitude' => $request->latitude,
			]);
		}

		if ($request->has('nationality_id') && !is_null($request->nationality_id)) {
			$client->update([
				'nationality_id' => $request->nationality_id,
			]);
		}

		if ($request->has('password') && !is_null($request->password)) {
			$client->update([
				'password' => bcrypt($request->password)
			]);
		}
		if ($request->has('gender') && !is_null($request->gender)) {
			$client->update([
				'gender' => $request->gender
			]);
		}
		$msg = 'تم تعديل البيانات بنجاح';
		if ($originalClient->accepted == "2") {
			if ($request->has("email")) {
				$emailChanged = $request->email != $originalClient->email;
			}
			if ($request->has("mobile")) {
				$mobileChanged = $phone != $originalClient->mobil;
			}
			$emailOrMobileChanged = $emailChanged || $mobileChanged;

			if ($emailOrMobileChanged) {
				if ($emailChanged && $mobileChanged) {
					$client->update([
						'confirmationType' => 'phone',
						'confirmationOtp' => $key,
						'changedBoth' => true
					]);

					$username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
					$password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
					$destinations = $client->mobil; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
					\Log::info($response);
					curl_close($curl);
					$msg = 'للمتابعة وتأكيد رقم الجوال
قم بإدخال الرمز المرسل على هاتفك';
				} else {
					$client->update([
						'confirmationType' => $emailChanged ? 'email' : 'phone',
						'confirmationOtp' => $key
					]);
					if ($emailChanged) {
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
							'subject' => "رابط تأكيد البريد . ",
							'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز واكتمال طلب التفعيل .  ",
							'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
							'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
							'bodyMessage3' => env('REACT_WEB_LINK') . '/auth/confirmEmail?otp=' . $key . '&type=client' . '&id=' . $client->id,
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
						$msg = 'تم بعث رابط التفعيل على بريدكم الإلكتروني بنجاح
بالضغط على رابط التفعيل المرسل فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز.';
					} else {
						if ($client->phone_code != "966") {
							$client->update([
								'confirmationType' => null,
								'confirmationOtp' => null,
								'accepted' => 2
							]);
							$emailOrMobileChanged = false;
						} else {
							$username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
							$password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
							$destinations = $client->mobil; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
							\Log::info($response);
							curl_close($curl);
							$msg = 'للمتابعة وتأكيد رقم الجوال
قم بإدخال الرمز المرسل على هاتفك';
						}
					}
				}
			} else {
				$client->update([
					'confirmationType' => null,
					'confirmationOtp' => null,
					'accepted' => 2
				]);
			}
		} else if ($client->accepted == "3") {
			if ($client->phone_code != "966") {
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
					'subject' => "رابط تأكيد البريد . ",
					'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز واكتمال طلب التفعيل .  ",
					'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
					'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
					'bodyMessage3' => env('REACT_WEB_LINK') . '/auth/confirmEmail?otp=' . $key . '&type=client' . '&id=' . $client->id,
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
					'confirmationType' => 'email',
					'confirmationOtp' => $key
				]);
				$msg = 'تم بعث رابط التفعيل على بريدكم الإلكتروني بنجاح
بالضغط على رابط التفعيل المرسل فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز.';
			} else {
				$username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
				$password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
				$destinations = $client->mobil; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
				$message = 'كود تفعيل الحساب : ' . ' ' . $key;      // محتوى الرسالة
				$message = urlencode($message);
				$sender = "Ymtaz.sa";         // اسم المرسل الخاص بك المفعل  في الموقع
				$url = "http://www.jawalbsms.ws/api.php/sendsms?user=$username&pass=$password&to=$destinations&message=$message&sender=$sender";
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
				$client->update([
					'confirmationType' => 'phone',
					'confirmationOtp' => $key
				]);
				$msg = 'للمتابعة وتأكيد رقم الجوال
قم بإدخال الرمز المرسل على هاتفك';
			}
		}
		$oldUser = ServiceUserOld::where('email', $request->email)->orWhere(['mobil' => $request->mobile, 'phone_code' => $request->phone_code])->first();
		if (!is_null($oldUser)) {
			if ($oldUser->accepted == 0) {
				$oldUser->update([
					'accepted' => 1
				]);
			}
		} else {
			$oldUser = LawyerOld::where('email', $request->email)->orWhere(['phone' => $request->mobile, 'phone_code' => $request->phone_code])->first();
			if (!is_null($oldUser)) {
				if ($oldUser->accepted == 0) {
					$oldUser->update([
						'accepted' => 1
					]);
				}
			}
		}
		$client = new ClientDataResource($client);
		return $this->sendResponse(true, $msg, compact('client'), 200);

	}
}
