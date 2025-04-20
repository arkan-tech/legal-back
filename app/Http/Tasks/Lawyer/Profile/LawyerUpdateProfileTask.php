<?php

namespace App\Http\Tasks\Lawyer\Profile;

use App\Models\Language;
use App\Models\LawyerOld;
use App\Http\Tasks\BaseTask;
use App\Models\Degree\Degree;
use App\Models\Lawyer\Lawyer;
use App\Models\ServiceUserOld;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\Models\Lawyer\LawyerSections;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Requests\API\Lawyer\Profile\LawyerUpdateProfileRequest;

class LawyerUpdateProfileTask extends BaseTask
{

	public function run(LawyerUpdateProfileRequest $request)
	{

		$lawyer = $this->authLawyer();
		$originalLawyer = Lawyer::find($lawyer->id);
		$phone = $request->phone;
		$changeHappened = false;
		$key = GenerateRegistrationRandomCode(6);
		$check = Lawyer::where('id', '<>', $lawyer->id)->where('phone', $phone)->first();
		if (!is_null($check)) {
			return $this->sendResponse(false, 'رقم الجوال موجود مسبقاً ', null, 422);

		}
		$special_degree_certificate_check = false;
		if ($request->has('sections')) {
			$lawyer_sections_ids = LawyerSections::where('lawyer_id', $lawyer->id)->pluck('section_id')->toArray();
			foreach ($request->sections as $section) {
				$item = DigitalGuideCategories::where('status', 1)->where('id', $section)->first();
				if (!is_null($item) && !in_array($item->id, $lawyer_sections_ids)) {
					if ($item->need_license == 1) {
						if (!is_null($request->licence_no)) {
							$check = array_key_exists($section, $request->licence_no);
						} else {
							$check = false;
						}

						if ($check == false) {
							return $this->sendResponse(false, 'عذراً هناك مشكلة . انت اخترت مهنة تحتاج الى ترخيص , وهي : ' . $item->title . ' ويجب ادخال لها رقم الترخيص . وشكراً ', null, 422);
						}
						$special_degree_certificate_check = false;
						if (!is_null($request->license_file)) {
							$check = array_key_exists($section, $request->license_file);
						} else {
							$check = false;
						}

						if ($check == false) {
							return $this->sendResponse(false, 'عذراً هناك مشكلة . انت اخترت مهنة تحتاج الى ترخيص , وهي : ' . $item->title . ' ويجب ادخال لها ملف اثيات الترخيص . وشكراً ', null, 422);
						}
						$special_degree_certificate_check = false;
					}

				}
			}
		}

		if ($request->has('degree')) {

			$degree = Degree::where('isYmtaz', 1)->findOrFail($request->degree);
			if ($degree->id != $lawyer->degree) {
				if ($degree->title == "أخرى") {
					if (!array_key_exists('degree_certificate', $request->all())) {
						return $this->sendResponse(false, 'يجب ادخال الشهادة العلمية', ["errors" => ["degree_certificate" => 'يجب ادخال الشهادة العلمية']], 422);
					}
					$degree = Degree::create([
						'title' => $request->other_degree,
					]);

				} else {
					if ($special_degree_certificate_check) {
						if ($degree->isSpecial) {
							if (!array_key_exists('degree_certificate', $request->all())) {
								return $this->sendResponse(false, 'يجب ادخال الشهادة العلمية', ["errors" => ["degree_certificate" => 'يجب ادخال الشهادة العلمية']], 422);
							}
						}
					} else {
						if (!array_key_exists('degree_certificate', $request->all())) {
							return $this->sendResponse(false, 'يجب ادخال الشهادة العلمية', ["errors" => ["degree_certificate" => 'يجب ادخال الشهادة العلمية']], 422);
						}
					}
				}
			}
		}

		$day = strlen($request->birth_day) == 1 ? '0' . $request->birth_day : $request->birth_day;
		$month = strlen($request->birth_month) == 1 ? '0' . $request->birth_month : $request->birth_month;
		$birthday = $request->birth_year . '-' . $month . '-' . $day;


		if ($request->has('first_name') && !is_null($request->first_name)) {
			$changeHappened = $this->checkChange($lawyer->first_name, $request->first_name);
			$lawyer->update([
				'first_name' => $request->first_name,

			]);
		}
		if ($request->has('second_name') && !is_null($request->second_name)) {
			$changeHappened = $this->checkChange($lawyer->second_name, $request->second_name);

			$lawyer->update([
				'second_name' => $request->second_name,

			]);
		}
		if ($request->has('third_name') && !is_null($request->third_name)) {
			$changeHappened = $this->checkChange($lawyer->third_name, $request->third_name);

			$lawyer->update([
				'third_name' => $request->third_name,

			]);
		} else {
			$lawyer->update([
				'third_name' => null
			]);
		}


		if ($request->has('fourth_name') && !is_null($request->fourth_name)) {
			$changeHappened = $this->checkChange($lawyer->fourth_name, $request->fourth_name);

			$lawyer->update([
				'fourth_name' => $request->fourth_name,
			]);
		}
		$lawyer_name = implode(" ", array_filter([
			$lawyer->first_name ?? '',
			$lawyer->second_name ?? '',
			$lawyer->third_name ?? '',
			$lawyer->fourth_name ?? '',
		]));

		$lawyer->update([
			'name' => $lawyer_name,
			'username' => $lawyer_name,
		]);


		if ($request->has('email') && !is_null($request->email)) {
			$lawyer->update([
				'email' => $request->email,
			]);
		}


		if ($request->has('phone_code') && !is_null($request->phone_code)) {
			$lawyer->update([
				'phone_code' => $request->phone_code,
			]);
		}


		if ($request->has('phone') && !is_null($request->phone)) {
			$phone = $request->phone;
			$lawyer->update([
				'phone' => $phone,
			]);
		}


		if ($request->has('about') && !is_null($request->about)) {
			$changeHappened = $this->checkChange($lawyer->about, $request->about);

			$lawyer->update([
				'about' => $request->about,
			]);
		}

		if ($request->has('accurate_specialty') && !is_null($request->accurate_specialty)) {
			$changeHappened = $this->checkChange($lawyer->accurate_specialty, $request->accurate_specialty);

			$lawyer->update([
				'accurate_specialty' => $request->accurate_specialty,
			]);
		}

		if ($request->has('general_specialty') && !is_null($request->general_specialty)) {
			$changeHappened = $this->checkChange($lawyer->general_specialty, $request->general_specialty);

			$lawyer->update([
				'general_specialty' => $request->general_specialty,
			]);
		}

		if ($request->has('gender') && !is_null($request->gender)) {
			$changeHappened = $this->checkChange($lawyer->gender, $request->gender);

			$lawyer->update([
				'gender' => $request->gender,
			]);
		}

		if ($request->has('degree') && !is_null($request->degree)) {
			$changeHappened = $this->checkChange($lawyer->degree, $request->degree);

			$lawyer->update([
				'degree' => $degree->id,
			]);
		}

		if ($request->has('birth_day') && !is_null($request->birth_day)) {
			$changeHappened = $this->checkChange($lawyer->birth_day, $request->birth_day);

			$day = strlen($request->birth_day) == 1 ? '0' . $request->birth_day : $request->birth_day;
			$month = strlen($lawyer->month) == 1 ? '0' . $lawyer->month : $lawyer->month;
			$birthday = $lawyer->year . '-' . $month . '-' . $day;
			$lawyer->update([
				'day' => $day,
				'birthday' => $birthday,
			]);
		}

		if ($request->has('birth_month') && !is_null($request->birth_month)) {
			$changeHappened = $this->checkChange($lawyer->birth_month, $request->birth_month);

			$day = strlen($lawyer->day) == 1 ? '0' . $lawyer->day : $lawyer->day;
			$month = strlen($request->birth_month) == 1 ? '0' . $request->birth_month : $request->birth_month;
			$birthday = $lawyer->year . '-' . $month . '-' . $day;
			$lawyer->update([
				'month' => $month,
				'birthday' => $birthday,
			]);
		}
		if ($request->has('birth_year') && !is_null($request->birth_year)) {
			$changeHappened = $this->checkChange($lawyer->birth_year, $request->birth_year);

			$day = strlen($lawyer->day) == 1 ? '0' . $lawyer->day : $lawyer->day;
			$month = strlen($lawyer->month) == 1 ? '0' . $lawyer->month : $lawyer->month;
			$birthday = $request->birth_year . '-' . $month . '-' . $day;
			$lawyer->update([
				'year' => $request->birth_year,
				'birthday' => $birthday,
			]);
		}
		if ($request->has('nationality') && !is_null($request->nationality)) {
			$changeHappened = $this->checkChange($lawyer->nationality, $request->nationality);

			$lawyer->update([
				'nationality' => $request->nationality,
			]);
		}

		if ($request->has('country') && !is_null($request->country)) {
			$changeHappened = $this->checkChange($lawyer->country, $request->country);

			$lawyer->update([
				'country_id' => $request->country,
			]);
		}


		if ($request->has('region') && !is_null($request->region)) {
			$changeHappened = $this->checkChange($lawyer->region, $request->region);

			$lawyer->update([
				'region' => $request->region,
			]);
		}


		if ($request->has('city') && !is_null($request->city)) {
			$changeHappened = $this->checkChange($lawyer->city, $request->city);

			$lawyer->update([
				'city' => $request->city,
			]);
		}


		if ($request->has('longitude') && !is_null($request->longitude)) {
			$changeHappened = $this->checkChange($lawyer->longitude, $request->longitude);

			$lawyer->update([
				'longitude' => $request->longitude,
			]);
		}
		if ($request->has('latitude') && !is_null($request->latitude)) {
			$changeHappened = $this->checkChange($lawyer->latitude, $request->latitude);

			$lawyer->update([
				'latitude' => $request->latitude,
			]);
		}

		if ($request->has('type') && !is_null($request->type)) {
			$changeHappened = $this->checkChange($lawyer->type, $request->type);

			$lawyer->update([
				'type' => $request->type,
			]);
		}


		if ($request->has('identity_type') && !is_null($request->identity_type)) {
			$changeHappened = $this->checkChange($lawyer->identity_type, $request->identity_type);

			$lawyer->update([
				'identity_type' => $request->identity_type,
			]);
		}


		if ($request->has('nat_id') && !is_null($request->nat_id)) {
			$changeHappened = $this->checkChange($lawyer->nat_id, $request->nat_id);

			$lawyer->update([
				'nat_id' => $request->nat_id,
			]);
		}


		if ($request->has('functional_cases') && !is_null($request->functional_cases)) {
			$changeHappened = $this->checkChange($lawyer->functional_cases, $request->functional_cases);

			$lawyer->update([
				'functional_cases' => $request->functional_cases,
			]);
		}

		if ($request->has('company_lisences_no') && !is_null($request->company_lisences_no)) {
			$changeHappened = $this->checkChange($lawyer->company_lisences_no, $request->company_lisences_no);

			$lawyer->update([
				'company_lisences_no' => $request->company_lisences_no,
			]);
		}

		if ($request->has('company_name') && !is_null($request->company_name)) {
			$changeHappened = $this->checkChange($lawyer->company_name, $request->company_name);

			$lawyer->update([
				'company_name' => $request->company_name,
			]);
		}


		if ($request->has('password') && !is_null($request->password)) {
			$lawyer->update([
				'password' => bcrypt($request->password)
			]);
		}

		if ($request->has('languages') && !is_null($request->languages)) {
			$lawyer->languages()->detach();
			foreach ($request->languages as $language) {
				$language = Language::findOrFail($language);
				$lawyer->languages()->attach($language);
			}
		}

		if ($request->has('photo')) {
			$changeHappened = true;

			$lawyer->update([
				'photo' => saveImage($request->file('photo'), 'uploads/lawyers/personal_image/')
			]);
		}
		if ($request->has('logo')) {
			$changeHappened = true;

			$lawyer->update([
				'logo' => saveImage($request->file('logo'), 'uploads/lawyers/logo/')
			]);
		}
		if ($request->has('id_file')) {
			$changeHappened = true;

			$lawyer->update([
				'id_file' => saveImage($request->file('id_file'), 'uploads/lawyers/id_file/')
			]);
		}
		if ($request->has('cv')) {
			$changeHappened = true;

			$lawyer->update([
				'cv' => saveImage($request->file('cv'), 'uploads/lawyers/cv/')
			]);
		}
		if ($request->has('degree_certificate')) {
			$changeHappened = true;

			$lawyer->update([
				'degree_certificate' => saveImage($request->file('degree_certificate'), 'uploads/lawyers/degree_certificate/')
			]);
		}

		if ($request->has('company_lisences_file')) {
			$changeHappened = true;

			$lawyer->update([
				'company_lisences_file' => saveImage($request->file('company_lisences_file'), 'uploads/lawyers/company_lisences_file/')
			]);
		}


		if ($request->has('sections')) {
			$lawyer->SectionsRel()->detach();
			foreach ($request->sections as $section) {
				$section = DigitalGuideCategories::findOrFail($section);
				$lawyer->SectionsRel()->attach($section);
			}
		}


		if ($request->has('licence_no')) {
			foreach ($request->licence_no as $section_id => $licen_no) {
				$item = LawyerSections::where('lawyer_id', $lawyer->id)->where('section_id', $section_id)->first();
				if (!is_null($item)) {
					$item->update([
						'licence_no' => $licen_no
					]);
				}
			}

			$lawyer->update([
				'has_licence_no' => 1
			]);
		}

		if ($request->has('license_file')) {
			foreach ($request->license_file as $section_id => $license_file) {
				$item = LawyerSections::where('lawyer_id', $lawyer->id)->where('section_id', $section_id)->first();
				if (!is_null($item)) {
					$item->update([
						'licence_file' => saveImage($license_file, 'uploads/lawyers/license_file/')
					]);
				}
			}
		}
		if ($originalLawyer->accepted == "2") {
			if ($request->has("email")) {
				$emailChanged = $request->email != $originalLawyer->email;
			}
			if ($request->has("phone")) {
				$mobileChanged = $phone != $originalLawyer->phone;
			}
			$emailOrMobileChanged = $emailChanged || $mobileChanged;
			if ($emailOrMobileChanged) {

				if ($emailChanged && $mobileChanged) {
					$lawyer->update([
						'confirmationType' => 'phone',
						'confirmationOtp' => $key,
						'changedBoth' => true
					]);
					$username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
					$password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
					$destinations = $lawyer->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
					$lawyer->update([
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
						$msg = 'تم ارسال رمز التفعيل على بريدكم الإلكتروني بنجاح
    قم بإدخال الرمز المرسل على البريد.';
					} else {
						if ($lawyer->phone_code != "966") {
							$lawyer->update([
								'confirmationType' => null,
								'confirmationOtp' => null,
								'accepted' => 1
							]);
							$emailOrMobileChanged = false;
						} else {
							$username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
							$password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
							$destinations = $lawyer->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
				$lawyer->update([
					'confirmationType' => null,
					'confirmationOtp' => null,
					'accepted' => 1
				]);
				$msg = 'تم تعديل البيانات بنجاح';
			}
		} else if ($lawyer->accepted == "3") {
			if ($lawyer->phone_code != "966") {
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
					'subject' => "رابط تأكيد البريد . ",
					'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز واكتمال طلب التفعيل .  ",
					'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
					'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
					'bodyMessage3' => env('REACT_WEB_LINK') . '/auth/confirmEmail?otp=' . $key . '&id=' . $lawyer->id . '&type=lawyer',
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
				$lawyer->update([
					'confirmationType' => 'email',
					'confirmationOtp' => $key
				]);
				$msg = 'تم بعث رابط التفعيل على بريدكم الإلكتروني بنجاح
بالضغط على رابط التفعيل المرسل فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز.';
			} else {
				$username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
				$password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
				$destinations = $lawyer->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
				$lawyer->update([
					'confirmationType' => 'phone',
					'confirmationOtp' => $key
				]);
				$msg = 'للمتابعة وتأكيد رقم الجوال
قم بإدخال الرمز المرسل على هاتفك';
			}
		}
		$oldUser = LawyerOld::where('email', $request->email)->orWhere(['phone' => $request->phone, 'phone_code' => $request->phone_code])->first();
		if (!is_null($oldUser)) {
			if ($oldUser->accepted == 0) {
				$oldUser->update([
					'accepted' => 1
				]);
			}
		} else {
			$oldUser = ServiceUserOld::where('email', $request->email)->orWhere(['mobil' => $request->phone, 'phone_code' => $request->phone_code])->first();

			if (!is_null($oldUser)) {
				if ($oldUser->accepted == 0) {
					$oldUser->update([
						'accepted' => 1
					]);
				}
			}
		}
		$lawyer = new LawyerShortDataResource($lawyer);
		return $this->sendResponse(true, $msg, compact('lawyer'), 200);
	}
	public function checkChange($attribute, $value)
	{
		if (is_array($attribute) && is_array($value)) {
			// Check if arrays are different
			if ($attribute != $value) {
				return true;
			}
		} elseif ($attribute != $value) {
			return true;
		}
		return false;
	}
}
