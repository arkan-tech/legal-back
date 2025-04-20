<?php

namespace App\Http\Tasks\Client\Auth\Login;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Service\ServiceUser;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\ClientNewDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Requests\API\Client\Auth\Login\ClientLoginRequest;

class ClientNewLoginTask extends BaseTask
{
    public function run(ClientLoginRequest $request)
    {
        $client = ServiceUser::where('mobil', $request->credential1)->orWhere('email', $request->credential1)->first();
        if (is_null($client)) {
            return $this->sendResponse(false, 'خطأ في الهاتف أو كلمة المرور', null, 401);
        }
        if ($client->active == 0) {
            return $this->sendResponse(false, 'يجب تفعيل حسابك , حسابك في انتظار التفعيل ', null, 401);
        }
        if ($client->status == 0) {
            return $this->sendResponse(false, 'عذراً , لا يمكنك الدخول بسبب حذف الحساب ', null, 401);
        }

        $credentials = request(['credential1', 'password']);
        $token = auth()->guard('api_client')->attempt(
            $this->ClientCredentials($request),
            $request->filled('remember')
        );
        if (!$token) {
            return $this->sendResponse(false, 'خطأ في الهاتف أو كلمة المرور', null, 401);

        }
  
        $token = JWTAuth::fromUser($client);
        $client->injectToken($token);
        $clientData  = new ClientNewDataResource($client);
        return $this->sendResponse(true, 'تم تسجيل الدخول بنجاح', [
            'client' => $clientData,
            // 'token'  => $token,
        ], 200);

    }

    protected function ClientCredentials(Request $request)
    {

        if (is_numeric($request->get('credential1'))) {
            return ['mobil' => $request->get('credential1'), 'password' => $request->get('password')];
        } elseif (filter_var($request->get('credential1'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('credential1'), 'password' => $request->get('password')];
        }
        return ['email' => $request->get('credential1'), 'password' => $request->get('password')];
    }

}