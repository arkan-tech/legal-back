<?php

namespace App\Http\Tasks\Lawyer\GeneralData\Nationalities;

use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Nationalities\LawyerNationalitiesResource;
use App\Http\Tasks\BaseTask;
use App\Models\Country\Country;
use App\Models\Country\Nationality;
use App\Models\Degree\Degree;

class getLawyerNationalitiesTask extends BaseTask
{
    public function run(){
        $nationalities = LawyerNationalitiesResource::collection(Nationality::where('status',1)->orderBy('created_at','desc')->get());
        return $this->sendResponse(true ,' الجنسيات',compact('nationalities'),200);
    }

}
