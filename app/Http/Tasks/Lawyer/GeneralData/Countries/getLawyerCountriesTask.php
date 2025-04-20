<?php

namespace App\Http\Tasks\Lawyer\GeneralData\Countries;

use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerCountriesResource;
use App\Http\Tasks\BaseTask;
use App\Models\Country\Country;
use App\Models\Degree\Degree;

class getLawyerCountriesTask extends BaseTask
{
    public function run(){
        $Countries = LawyerCountriesResource::collection(Country::where('status',1)->get());
        return $this->sendResponse(true ,' الدول',compact('Countries'),200);
    }

}
