<?php

namespace App\Http\Tasks\Lawyer\Auth\Password;

use App\Http\Requests\API\Lawyer\Auth\Password\LawyerPostForgotPasswordRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Mail;

class LawyerPostForgotPasswordTask extends BaseTask
{
	public function run(LawyerPostForgotPasswordRequest $request)
	{
		$lawyer = Lawyer::where('email', $request->email)->first();
		if (!$lawyer) {
			return $this->sendResponse(false, 'خطأ في الايميل , نرجو اضافة الايميل الذي تم استخدامه حتى نتمكن من ارسال عليه كود التحقق ', null, 422);
		} else {
			$key = rand(1231, 7879);
			$lawyer->update([
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
				'name' => $lawyer->name,
				'email' => ($lawyer->email),
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

	}
}
