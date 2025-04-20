<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Http\Requests\CheckPhoneRequest;
use App\Http\Tasks\Merged\Auth\ConfirmOtp;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\RegisterAccountRequest;
use App\Http\Tasks\Merged\Auth\ConfirmEmailTask;
use App\Http\Requests\API\Merged\AccountLoginRequest;
use App\Http\Tasks\Merged\Auth\ResendConfirmationOtp;
use App\Http\Requests\CheckForgetPasswordTokenRequest;
use App\Http\Tasks\Merged\Auth\ConfirmEmailLawyerTask;
use App\Http\Tasks\Merged\Auth\Register\CheckPhoneTask;
use App\Http\Tasks\Merged\Auth\Register\AccountCheckTask;
use App\Http\Tasks\Merged\Auth\Register\ConfirmPhoneTask;
use App\Http\Tasks\Merged\Auth\Register\LoginAccountTask;
use App\Http\Tasks\Merged\Auth\Password\ChangePasswordTask;
use App\Http\Tasks\Merged\Auth\Register\RegisterAccountTask;
use App\Http\Tasks\Merged\Auth\Password\CreateForgotPasswordTask;
use App\Http\Tasks\Merged\Auth\Password\ForgotPasswordVerificationTask;

class AuthController extends BaseController
{
    public function confirmOtp(Request $request, ConfirmOtp $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function confirmEmail(Request $request, ConfirmEmailTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function confirmEmailLawyer(Request $request, ConfirmEmailLawyerTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function resendOtp(Request $request, ResendConfirmationOtp $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function register(RegisterAccountRequest $request, RegisterAccountTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function checkPhone(CheckPhoneRequest $request, CheckPhoneTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function confirmPhone(Request $request, ConfirmPhoneTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function login(AccountLoginRequest $request, LoginAccountTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function check(Request $request, AccountCheckTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function createForgetPassword(ForgetPasswordRequest $request, CreateForgotPasswordTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function checkForgetPassword(CheckForgetPasswordTokenRequest $request, ForgotPasswordVerificationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function changePassword(ResetPasswordRequest $request, ChangePasswordTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

}
