<?php

namespace App\Http\Controllers\API\Lawyer\Settings;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\FavoritesLawyers\ClientAddFavoritesLawyersRequest;
use App\Http\Requests\API\Lawyer\Auth\Login\LawyerLoginRequest;
use App\Http\Requests\API\Lawyer\Auth\Password\LawyerForgotPasswordVerificationRequest;
use App\Http\Requests\API\Lawyer\Auth\Password\LawyerPostForgotPasswordRequest;
use App\Http\Requests\API\Lawyer\Auth\Password\LawyerResetPasswordRequest;
use App\Http\Requests\API\Lawyer\Auth\Register\LawyerRegisterRequest;
use App\Http\Requests\API\Lawyer\FavoritesLawyers\LawyerAddFavoritesLawyersRequest;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\Lawyer\LawyerCreateReservationLawyerRequest;
use App\Http\Requests\API\Lawyer\Profile\LawyerUpdateProfileRequest;
use App\Http\Tasks\Client\Auth\Logout\ClientLogoutTask;
use App\Http\Tasks\Client\FavoritesLawyers\ClientAddFavoritesLawyersTask;
use App\Http\Tasks\Client\FavoritesLawyers\ClientListFavoritesLawyersTask;
use App\Http\Tasks\Lawyer\Auth\Login\LawyerLoginTask;
use App\Http\Tasks\Lawyer\Auth\Logout\LawyerLogoutTask;
use App\Http\Tasks\Lawyer\Auth\Password\LawyerForgotPasswordVerificationTask;
use App\Http\Tasks\Lawyer\Auth\Password\LawyerPostForgotPasswordTask;
use App\Http\Tasks\Lawyer\Auth\Password\LawyerResetPasswordTask;
use App\Http\Tasks\Lawyer\Auth\Register\LawyerRegisterTask;
use App\Http\Tasks\Lawyer\FavoritesLawyers\LawyerAddFavoritesLawyersTask;
use App\Http\Tasks\Lawyer\FavoritesLawyers\LawyerListFavoritesLawyersTask;
use App\Http\Tasks\Lawyer\LawyerAdvisoryServices\Lawyer\LawyerCreateLawyerReservationTask;
use App\Http\Tasks\Lawyer\Profile\LawyerGetProfileDataTask;
use App\Http\Tasks\Lawyer\Profile\LawyerUpdateProfileTask;
use App\Http\Tasks\Lawyer\Settings\LawyerTermsAndConditionsTask;
use Illuminate\Http\Request;

class LawyerSettingsController extends BaseController
{
    public function LawyerTermsAndConditions(Request $request, LawyerTermsAndConditionsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
}
