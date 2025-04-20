<?php

namespace App\Http\Controllers\Site\Lawyer\Password;

use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Http\Request;
use carbon\carbon;
use Mail;

class RestorePasswordController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('site.lawyers.password.restore_password');
	}

	public function postForgotPassword(Request $request)
	{
		$chechLawyer = Lawyer::Where('email', $request->email)->first();
		if (!$chechLawyer) {
			$user = ServiceUser::where('email', $request->email)->first();
			if (!$user) {
				return redirect()->back()->with('forgotError', 'عذرا هذا البريد الالكترونى غير موجود');
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
	}

	public function resetPassword(Request $request)
	{
		$hash = $request->hash;
		$chechLawyer = Lawyer::where('pass_code', $request->hash)->first();

		if (!$chechLawyer) {
			return redirect()->route('site.lawyer.password.index')->with('error', 'عذرا لقد قمت باتباع رابط خاطئ');
		}
		return view('site.lawyers.password.reset_password', compact('hash'));
	}
	public function postResetPassword(Request $request)
	{
		$chechLawyer = Lawyer::where('pass_code', $request->hash)->first();

		if (!$chechLawyer) {
			return redirect()->back()->with('error', 'عذرا لقد قمت باتباع رابط خاطئ');
		} else {
			$chechLawyer->password = bcrypt($request->password);
			$chechLawyer->pass_reset = 0;
			$chechLawyer->pass_code = null;
			$chechLawyer->update();
			return redirect()->route('site.lawyer.show.login.form')->with('success-reset-password', 'تم تغيير كلمة المرور الخاصة بك بنجاح.');
		}
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
