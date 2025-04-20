<?php

namespace App\Http\Controllers\API\Client\Auth\Register;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Client\Auth\ClientgetUserDataTask;
use App\Http\Tasks\Client\Auth\Login\ClientCheckTask;
use App\Http\Tasks\Client\Auth\Login\ClientLoginTask;
use App\Http\Tasks\Client\Auth\Logout\ClientLogoutTask;
use App\Http\Tasks\Client\Auth\Login\ClientNewLoginTask;
use App\Http\Tasks\Client\Auth\Register\ClientRegisterTask;
use App\Http\Tasks\Client\Auth\Register\ClientConfirmOtpTask;
use App\Http\Requests\API\Client\Auth\Login\ClientLoginRequest;
use App\Http\Tasks\Client\Auth\Password\ClientResetPasswordTask;
use App\Http\Tasks\Client\Auth\Register\ClientActivateAccountTask;
use App\Http\Requests\API\Client\Auth\Register\ClientRegisterRequest;
use App\Http\Tasks\Client\Auth\Password\ClientPostForgotPasswordTask;
use App\Http\Requests\API\Client\Auth\Password\ClientResetPasswordRequest;
use App\Http\Requests\API\Client\Auth\Register\ClientActivateAccountRequest;
use App\Http\Tasks\Client\Auth\Password\ClientForgotPasswordVerificationTask;
use App\Http\Requests\API\Client\Auth\Password\ClientPostForgotPasswordRequest;
use App\Http\Requests\API\Client\Auth\Password\ClientForgotPasswordVerificationRequest;

class ClientAuthController extends BaseController
{
    public function register(ClientRegisterRequest $request, ClientRegisterTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function ActivateAccount(ClientActivateAccountRequest $request, ClientActivateAccountTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function login(ClientLoginRequest $request, ClientLoginTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function logout(Request $request, ClientLogoutTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function postForgotPassword(ClientPostForgotPasswordRequest $request, ClientPostForgotPasswordTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function forgotPasswordVerification(ClientForgotPasswordVerificationRequest $request, ClientForgotPasswordVerificationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function resetPassword(ClientResetPasswordRequest $request, ClientResetPasswordTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function Check(Request $request, ClientCheckTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function newLogin(ClientLoginRequest $request, ClientNewLoginTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function confirmOtp(Request $request, ClientConfirmOtpTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
