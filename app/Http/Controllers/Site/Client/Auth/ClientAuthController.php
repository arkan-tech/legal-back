<?php

namespace App\Http\Controllers\Site\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class ClientAuthController extends Controller
{
	use AuthenticatesUsers;


	public function showLoginForm()
	{

		if ($this->guard()->user()) {
			return redirect()->route('site.index');
		}

		return redirect()->env('REACT_WEB_LINK') . "/auth/signin";
	}

	public function postLogin(Request $request)
	{
		$this->validateLogin($request);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if (
			method_exists($this, 'hasTooManyLoginAttempts') &&
			$this->hasTooManyLoginAttempts($request)
		) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}
		$credentials = $this->credentials($request);
		$user = ServiceUser::where('mobil', $request->credential1)->orWhere('email', $request->credential1)->first();
		if (!is_null($user)) {

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
				$this->username() => ['عذراً,الحساب غير موجود '],
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
			return redirect()->route('site.client.show-em-login')->with('waiting-accept', '');
		} else if ($user->accepted == 2) {
			return $request->wantsJson()
				? new JsonResponse([], 204)
				: redirect()->route('site.client.profile.index');
		} else if ($user->accepted == 3) {
			return redirect()->route('site.client.show-em-login')->with('waiting', $user->id);
		} else if ($user->accepted == 0) {
			return redirect()->route('site.lawyer.show-em-login')->with('blocked', $user->id);
		} else if ($user->active == 0) {
			return redirect()->route('site.client.show-em-login')->with('waiting', $user->id);
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
		return Auth::guard('client');
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
			return ['mobil' => $request->get('credential1'), 'password' => $request->get('password')];
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


	public function showEmptyLogin()
	{
		return view('site.client.auth.empty_login');
	}
}
