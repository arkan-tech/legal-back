<?php

namespace App\Http\Tasks;

class BaseTask
{
    public function sendResponse($status = false, $message = '', $data = '', $code = 404)
    {
        return compact('status', 'message', 'data', 'code');
    }

    public function authClient()
    {
        return auth()->guard('api_client')->user();
    }
    public function authAccount()
    {
        return auth()->guard('api_account')->user();
    }
    public function authLawyer()
    {
        return auth()->guard('api_lawyer')->user();
    }

    public function authClientCheck()
    {
        return auth()->guard('api_client')->check();
    }
    public function authLawyerCheck()
    {
        return auth()->guard('api_lawyer')->check();
    }


}
