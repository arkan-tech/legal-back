<?php

namespace App\Http\Controllers\API\Lawyer\GeneralData;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserPasswordRequest;
use App\Http\Requests\API\Client\Profile\ClientUpdateUserProfileRequest;
use App\Http\Tasks\Client\Profile\ClientGetUserProfileTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserPasswordTask;
use App\Http\Tasks\Client\Profile\ClientUpdateUserProfileTask;
use App\Http\Tasks\Lawyer\GeneralData\Cities\getLawyerCitiesTask;
use App\Http\Tasks\Lawyer\GeneralData\Countries\getLawyerCountriesTask;
use App\Http\Tasks\Lawyer\GeneralData\Degrees\getLawyerDegreesTask;
use App\Http\Tasks\Lawyer\GeneralData\Districts\getLawyerDistrictsTask;
use App\Http\Tasks\Lawyer\GeneralData\FunctionalCases\getLawyerFunctionalCasesTask;
use App\Http\Tasks\Lawyer\GeneralData\LawyerTypes\getLawyerTypesTask;
use App\Http\Tasks\Lawyer\GeneralData\Nationalities\getLawyerNationalitiesTask;
use App\Http\Tasks\Lawyer\GeneralData\Regions\getLawyerRegionsTask;
use App\Http\Tasks\Lawyer\GeneralData\Section\getLawyerSectionTask;
use App\Http\Tasks\Lawyer\GeneralData\Specialty\getLawyerAccurateSpecialtyTask;
use App\Http\Tasks\Lawyer\GeneralData\Specialty\getLawyerGeneralSpecialtyTask;
use App\Http\Tasks\Lawyer\GeneralData\getLanguagesTask;
use App\Http\Tasks\Splash\getSplashListTask;
use Illuminate\Http\Request;

class GeneralDataLawyerRegisterController extends BaseController
{
    public function getGeneralSpecialty(Request $request, getLawyerGeneralSpecialtyTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getAccurateSpecialty(Request $request, getLawyerAccurateSpecialtyTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getFunctionalCases(Request $request, getLawyerFunctionalCasesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getSections(Request $request, getLawyerSectionTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getDegrees(Request $request, getLawyerDegreesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getCountries(Request $request, getLawyerCountriesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getNationalities(Request $request, getLawyerNationalitiesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getRegions(Request $request, getLawyerRegionsTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getCities(Request $request, getLawyerCitiesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getDistricts(Request $request, getLawyerDistrictsTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getLawyerTypes(Request $request, getLawyerTypesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getLanguages(Request $request, getLanguagesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
