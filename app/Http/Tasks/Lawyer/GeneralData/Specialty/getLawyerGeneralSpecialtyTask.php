<?php

namespace App\Http\Tasks\Lawyer\GeneralData\Specialty;

use App\Http\Resources\API\Lawyer\GeneralData\LawyerDegreestResource;
use App\Http\Resources\API\Lawyer\GeneralData\Specialty\LawyerGeneralSpecialtyResource;
use App\Http\Tasks\BaseTask;
use App\Models\Degree\Degree;
use App\Models\Specialty\GeneralSpecialty;

class getLawyerGeneralSpecialtyTask extends BaseTask
{
    public function run(){
        $GeneralSpecialty = LawyerGeneralSpecialtyResource::collection(GeneralSpecialty::where('status',1)->orderBy('created_at','desc')->get());
        return $this->sendResponse(true ,' التخصصات العامة',compact('GeneralSpecialty'),200);

    }

}
