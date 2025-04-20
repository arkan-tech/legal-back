<?php

namespace App\Http\Tasks\Lawyer\GeneralData\LawyerTypes;

use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\LawyerTypes\LawyerLawyerTypesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Nationalities\LawyerNationalitiesResource;
use App\Http\Tasks\BaseTask;
use App\Models\Country\Country;
use App\Models\Country\Nationality;
use App\Models\Degree\Degree;
use App\Models\Lawyer\LawyerType;

class getLawyerTypesTask extends BaseTask
{
    public function run(){
        $types = LawyerLawyerTypesResource::collection(LawyerType::where('status',1)->orderBy('created_at','desc')->get());
        return $this->sendResponse(true ,'صفات مقدمي الخدمة',compact('types'),200);
    }

}
