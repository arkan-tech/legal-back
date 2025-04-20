<?php

namespace App\Http\Tasks\Lawyer\Auth\Login;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Service\ServiceUser;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Resources\API\Lawyer\LawyerNewShortDataResource;
use App\Http\Requests\API\Lawyer\Auth\Login\LawyerLoginRequest;

class LawyerNewLoginTask extends BaseTask
{
    public function run(LawyerLoginRequest $request)
    {

        $lawyer = Lawyer::where('phone', $request->credential1)->orWhere('email', $request->credential1)->first();
        if (is_null($lawyer)) {
            return $this->sendResponse(false, 'خطأ في الهاتف أو كلمة المرور', null, 401);
        }
        $credentials = request(['credential1', 'password']);
        $token = auth()->guard('api_lawyer')->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
        if (!$token) {
            return $this->sendResponse(false, 'خطأ في الهاتف أو كلمة المرور', null, 401);

        }
        // if ($lawyer->accepted == 1) {
        //     return $this->sendResponse(false, 'حسابك قيد المراجعة لدى يمتاز , وستصلك رسالة حالة الحساب قريباً', null, 401);

        // }
        // if ($lawyer->accepted == 3) {
        //     return $this->sendResponse(false, 'حالة حسابك الآن في الانتظار ويجرى تحديث بياناتكم لاعتمادها مجدداً ', null, 401);

        // }
        // if ($lawyer->accepted == 0) {
        //     return $this->sendResponse(false, 'نأسف , لقد تم تعليق حسابك من الادارة  , ', null, 401);
        // }

        // if ($lawyer->profile_complete == 0) {
        //     return $this->sendResponse(false, 'نأسف يجب عليك اكمال معلوماتك حتى تتمكن من الاستفادة من الخدمات , ', null, 401);

        // }

        if ($lawyer->activate_email == 0) {
            return $this->sendResponse(false, 'نأسف يجب عليك مراجعة ايميلك حتى تتمكن من تفعيل الحساب واتباع الرابط الموجود  , ', null, 401);

        }

        $token = JWTAuth::fromUser($lawyer);
        $lawyer->injectToken($token);
        $lawyer = new LawyerNewShortDataResource($lawyer);
        return $this->sendResponse(true, 'تم  تسجيل الدخول بنجاح', compact('lawyer'), 200);

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
}
