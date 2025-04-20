<?php

namespace App\Http\Controllers\API\Lawyer\Auth\Register;

use App\Http\Tasks\Lawyer\Profile\LawyerGetAnalyticsTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Lawyer\Auth\Login\LawyerCheckTask;
use App\Http\Tasks\Lawyer\Auth\Login\LawyerLoginTask;
use App\Http\Tasks\Client\Auth\Logout\ClientLogoutTask;
use App\Http\Tasks\Lawyer\Auth\Logout\LawyerLogoutTask;
use App\Http\Tasks\Lawyer\Auth\Login\LawyerNewLoginTask;
use App\Http\Tasks\Lawyer\Profile\LawyerUpdateProfileTask;
use App\Http\Tasks\Lawyer\Auth\Register\LawyerRegisterTask;
use App\Http\Tasks\Lawyer\Profile\LawyerGetProfileDataTask;
use App\Http\Requests\API\Lawyer\Auth\Login\LawyerLoginRequest;
use App\Http\Tasks\Lawyer\Auth\Password\LawyerResetPasswordTask;
use App\Http\Tasks\Lawyer\Profile\LawyerDeleteAccountRequestTask;
use App\Http\Requests\API\Lawyer\Profile\LawyerUpdateProfileRequest;
use App\Http\Requests\API\Lawyer\Auth\Register\LawyerRegisterRequest;
use App\Http\Tasks\Lawyer\Auth\Password\LawyerPostForgotPasswordTask;
use App\Http\Tasks\Lawyer\Auth\Register\LawyerVerificationFirstStepTask;
use App\Http\Tasks\Client\FavoritesLawyers\ClientAddFavoritesLawyersTask;
use App\Http\Tasks\Lawyer\FavoritesLawyers\LawyerAddFavoritesLawyersTask;
use App\Http\Requests\API\Lawyer\Auth\Password\LawyerResetPasswordRequest;
use App\Http\Tasks\Client\FavoritesLawyers\ClientListFavoritesLawyersTask;
use App\Http\Tasks\Lawyer\FavoritesLawyers\LawyerListFavoritesLawyersTask;
use App\Http\Requests\API\Lawyer\Profile\LawyerDeleteAccountRequestRequest;
use App\Http\Tasks\Lawyer\Auth\Password\LawyerForgotPasswordVerificationTask;
use App\Http\Tasks\Lawyer\Auth\Register\LawyerCheckVerificationFirstStepTask;
use App\Http\Requests\API\Lawyer\Auth\Password\LawyerPostForgotPasswordRequest;
use App\Http\Requests\API\Lawyer\Auth\Register\LawyerVerificationFirstStepRequest;
use App\Http\Requests\API\Client\FavoritesLawyers\ClientAddFavoritesLawyersRequest;
use App\Http\Requests\API\Lawyer\FavoritesLawyers\LawyerAddFavoritesLawyersRequest;
use App\Http\Requests\API\Lawyer\Auth\Password\LawyerForgotPasswordVerificationRequest;
use App\Http\Requests\API\Lawyer\Auth\Register\LawyerCheckVerificationFirstStepRequest;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\Lawyer\LawyerCreateLawyerReservationTask;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\Lawyer\LawyerCreateReservationLawyerRequest;

class LawyerAuthController extends BaseController
{
    public function register(LawyerRegisterRequest $request, LawyerRegisterTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function verificationFirstStep(LawyerVerificationFirstStepRequest $request, LawyerVerificationFirstStepTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function CheckVerificationFirstStep(LawyerCheckVerificationFirstStepRequest $request, LawyerCheckVerificationFirstStepTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function UpdateProfile(LawyerUpdateProfileRequest $request, LawyerUpdateProfileTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function login(LawyerLoginRequest $request, LawyerLoginTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function postForgotPassword(LawyerPostForgotPasswordRequest $request, LawyerPostForgotPasswordTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function forgotPasswordVerification(LawyerForgotPasswordVerificationRequest $request, LawyerForgotPasswordVerificationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function resetPassword(LawyerResetPasswordRequest $request, LawyerResetPasswordTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getUserData(Request $request, LawyerGetProfileDataTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function logout(Request $request, LawyerLogoutTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }


    public function ListFavoritesLawyers(Request $request, LawyerListFavoritesLawyersTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function AddFavoritesLawyers(LawyerAddFavoritesLawyersRequest $request, LawyerAddFavoritesLawyersTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }


    public function CreateAdvisoryServicesReservations(LawyerCreateReservationLawyerRequest $request, LawyerCreateLawyerReservationTask $task)
    {

        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function Check(Request $request, LawyerCheckTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function DeleteAccountRequest(LawyerDeleteAccountRequestRequest $request, LawyerDeleteAccountRequestTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function newLogin(LawyerLoginRequest $request, LawyerNewLoginTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function analytics(Request $request, LawyerGetAnalyticsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
