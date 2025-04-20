<?php

namespace App\Http\Controllers\Site\Lawyer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lawyer\Lawyer;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class LawyerAuthController extends Controller
{
	use AuthenticatesUsers;


	public function showLoginForm()
	{

		if ($this->guard()->user()) {
			return redirect()->route('site.index');
		}

		return view('site.lawyers.auth.login');
	}

	public function postLogin(Request $request)
	{
		$this->validateLogin($request);
		if (
			method_exists($this, 'hasTooManyLoginAttempts') &&
			$this->hasTooManyLoginAttempts($request)
		) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}
		$credentials = $this->credentials($request);

		$user = Lawyer::where('phone', $request->credential1)->orWhere('email', $request->credential1)->first();
		if (!is_null($user)) {
			if ($user->activate_email == 0) {
				throw ValidationException::withMessages([
					$this->username() => ['حسابك غير مؤكد ويجب اتباع خطوات التأكيد '],
				]);
			}
			if ($this->guard()->attempt($credentials, $request->has('remember'))) {
				if ($request->hasSession()) {
					$request->session()->put('auth.password_confirmed_at', time());
				}
				return $this->sendLoginResponse($request, $user);
			} else {
				return $this->sendFailedLoginResponse($request);
			}
		} else {
			throw ValidationException::withMessages([
				$this->username() => ['عذرا ً,الحساب غير موجود '],
			]);
		}

	}

	protected function sendLoginResponse(Request $request, $user)
	{
		$request->session()->regenerate();

		$this->clearLoginAttempts($request);

		if ($response = $this->authenticated($request, $this->guard()->user())) {
			return $response;
		}

		if ($user->accepted == 1) {
			return redirect()->route('site.lawyer.show-em-login')->with('waiting-accept', '');
		} else if ($user->accepted == 2) {
			return $request->wantsJson()
				? new JsonResponse([], 204)
				: redirect()->route('site.lawyer.profile.show');
		} else if ($user->accepted == 3) {
			return redirect()->route('site.lawyer.show-em-login')->with('waiting', $user->id);
		} else if ($user->accepted == 0) {
			return redirect()->route('site.lawyer.show-em-login')->with('blocked', $user->id);
		} else if ($user->profile_complete == 0) {
			return redirect()->route('site.lawyer.show-em-login')->with('profile_complete', $user->id);
		}



	}

	protected function sendFailedLoginResponse(Request $request)
	{
		throw ValidationException::withMessages([
			$this->username() => ['خطأ في كلمة المرور او الايميل'],
		]);
	}

	protected function guard()
	{
		return Auth::guard('lawyer');
	}

	public function redirectTo()
	{
		return redirect()->route('site.index');
	}


	protected function validateLogin(Request $request)
	{
		$request->validate([
			$this->username() => 'required|string',
			'password' => 'required|string',
		]);
	}

	protected function attemptLogin(Request $request)
	{
		return $this->guard()->attempt(
			$this->credentials($request),
			$request->boolean('remember')
		);
	}


	protected function credentials(Request $request)
	{
		if (is_numeric($request->get('credential1'))) {
			return ['phone' => $request->get('credential1'), 'password' => $request->get('password')];
		} elseif (filter_var($request->get('credential1'), FILTER_VALIDATE_EMAIL)) {
			return ['email' => $request->get('credential1'), 'password' => $request->get('password')];
		}
		return ['email' => $request->get('credential1'), 'password' => $request->get('password')];
	}

	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username()
	{
		return 'credential1';
	}
	public function showEmptyLogin()
	{
		return view('site.lawyers.auth.empty_login');
	}

	public function logout(Request $request)
	{
		$this->guard()->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		if ($response = $this->loggedOut($request)) {
			return $response;
		}

		return $request->wantsJson()
			? new JsonResponse([], 204)
			: redirect()->env('REACT_WEB_LINK') . "/auth/signin";
	}
}
