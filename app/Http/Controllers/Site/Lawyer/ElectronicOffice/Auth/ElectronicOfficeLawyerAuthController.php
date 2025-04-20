<?php

namespace App\Http\Controllers\Site\Lawyer\ElectronicOffice\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lawyer\Lawyer;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class ElectronicOfficeLawyerAuthController extends Controller
{
    use AuthenticatesUsers;


    public function showLoginForm($id)
    {
        CheckElectronicOfficeLawyer($id);
        if ($this->guard()->check()) {

            return redirect()->route('site.lawyer.electronic-office.home', $id);
        }
        return view('site.lawyers.electronic_office.auth.login', get_defined_vars());
    }

    public function postLogin(Request $request)
    {
        CheckElectronicOfficeLawyer($request->electronic_id_code);

        $this->validateLogin($request);
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        $credentials = $this->credentials($request);

        $user = Lawyer::where('electronic_id_code', $request->electronic_id_code)->where('email', $credentials['email'])->first();

        if (!is_null($user)) {

            if ($user->accepted == 2) {
                if ($this->guard()->attempt($credentials, $request->has('remember'))) {
                    if ($request->hasSession()) {
                        $request->session()->put('auth.password_confirmed_at', time());
                    }
                    return $this->sendLoginResponse($request);
                }
                return $this->sendFailedLoginResponse($request);
            } elseif ($user->accepted == 1) {
                if ($this->guard()->attempt($credentials, $request->has('remember'))) {
                    return redirect()->route('site.lawyer.electronic-office.login.form')->with('waiting-accept', '');
                }
                return $this->sendFailedLoginResponse($request);

            } elseif ($user->accepted == 3) {
                if ($this->guard()->attempt($credentials, $request->has('remember'))) {
                    return redirect()->route('site.lawyer.electronic-office.login.form')->with('waiting', $user->id);
                }
                return $this->sendFailedLoginResponse($request);
            } elseif ($user->accepted == 0) {
                if ($this->guard()->attempt($credentials, $request->has('remember'))) {
                    return redirect()->route('site.lawyer.electronic-office.login.form')->with('blocked', $user->id);
                }
                return $this->sendFailedLoginResponse($request);

            }

        } else {
            throw ValidationException::withMessages([
                $this->username() => ['الحساب غير موجود '],
            ]);
        }

    }

    protected function sendLoginResponse(Request $request)
    {
        CheckElectronicOfficeLawyer($request->electronic_id_code);

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('site.lawyer.electronic-office.dashboard.index',$request->electronic_id_code);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['خطأ في كلمة المرور او الايميل'],
        ]);
    }

    protected function guard()
    {
        return Auth::guard('lawyer_electronic_office');
    }

    public function redirectTo()
    {
        return redirect()->route('site.lawyer.electronic-office.dashboard.index');
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
            $this->credentials($request), $request->boolean('remember')
        );
    }


    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }


    public function logout(Request $request,$id)
    {
        CheckElectronicOfficeLawyer($id);

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('site.lawyer.electronic-office.login.form',$id);
    }
}
