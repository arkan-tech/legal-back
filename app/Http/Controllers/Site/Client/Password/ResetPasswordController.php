<?php

namespace App\Http\Controllers\Site\Client\Password;

use App\Http\Controllers\Controller;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Http\Request;
use Mail;

class ResetPasswordController extends Controller
{
	public function ForgotPassword()
	{
		return view('site.client.auth.password.forgot-password');
	}

	public function postForgotPassword(Request $request)
	{
		$user = ServiceUser::where('email', $request->email)->first();
		if (!$user) {
			$chechLawyer = Lawyer::Where('email', $request->email)->first();
			if (!$chechLawyer) {
				return redirect()->back()->with('not-found-user', 'عذرا هذا البريد الالكترونى غير موجود');
			} else {

				$key = GenerateRandomKey();
				$chechLawyer->pass_code = $key;
				$chechLawyer->pass_reset = 1;
				$chechLawyer->save();
				$bodyMessage3 = '';
				$bodyMessage4 = 'لتسجيل الدخول ';
				$bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
				$bodyMessage6 = '';
				$bodyMessage7 = 'للتواصل والدعم الفني :';
				$bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
				$bodyMessage9 = '';
				$bodyMessage10 = 'نعتز بثقتكم';
				$data = [
					'name' => $chechLawyer->name,
					'email' => ($chechLawyer->email) ? $chechLawyer->email : $chechLawyer->username,
					'subject' => " استعادة كلمة المرور الخاصة بك ",
					'bodyMessage' => "أهلاً بك شريكنا العزيز .  ",
					'bodyMessage1' => 'لاستعادة كلمة المرور الخاصة بك يرجى الضغط على هذا الرابط:',
					'bodyMessage2' => route('site.lawyer.password.reset-password', $key),
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
					$data,
					function ($message) use ($data) {
						$message->from('ymtaz@ymtaz.sa');
						$message->to($data['email'], $data['name'])->subject($data['subject']);
					}
				);
				return redirect()->route('site.lawyer.password.success-send-email')->with('success', 'تم ارسال رابط تغيير كلمة المرور بنجاح على الايميل , تفقد ايميلك');

			}
		} else {
			$key = GenerateRandomKey();
			$user->update([
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
				'name' => $user->myname,
				'email' => $user->email,
				'subject' => " استعادة كلمة المرور الخاصة بك ",
				'bodyMessage' => "أهلاً بك شريكنا العزيز .  ",
				'bodyMessage1' => 'لاستعادة كلمة المرور الخاصة بك يرجى الضغط على هذا الرابط:',
				'bodyMessage2' => route('site.client.reset-password', $key),
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

			return redirect()->back()->with('successPostForgotPassword', 'تم ارسال لك على الايميل الذي قمت بادخاله رابط ل اعادة تعيين كلمة المرور , شكراً لحسن تعاونكم معنا.');
		}


	}

	public function resetPassword($key)
	{
		return view('site.client.auth.password.reset-password', compact('key'));
	}
	public function postResetPassword(Request $request)
	{
		$client = ServiceUser::where('pass_code', $request->hash)->first();
		if (!$client) {
			return redirect()->back()->with('resetError', 'عذرا لقد قمت باتباع رابط خاطئ');
		} else {
			$client->update([
				'password' => bcrypt($request->password),
				'pass_reset' => 0,
				'pass_code' => null,
			]);
			return redirect()->route('site.client.show.login.form')->with('successPostForgotPassword', 'تم تغيير كلمة المرور الخاصة بك بنجاح.');
		}
	}
}
