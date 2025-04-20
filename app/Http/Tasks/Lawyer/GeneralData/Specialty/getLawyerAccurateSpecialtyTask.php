<?php

namespace App\Http\Tasks\Lawyer\GeneralData\Specialty;

use App\Http\Resources\API\Lawyer\GeneralData\LawyerDegreestResource;
use App\Http\Resources\API\Lawyer\GeneralData\Specialty\LawyerAccurateSpecialtyResource;
use App\Http\Tasks\BaseTask;
use App\Models\Degree\Degree;
use App\Models\Specialty\AccurateSpecialty;

class getLawyerAccurateSpecialtyTask extends BaseTask
{
    public function run(){
        $AccurateSpecialty= LawyerAccurateSpecialtyResource::collection(AccurateSpecialty::where('status',1)->orderBy('created_at','desc')->get());
        return $this->sendResponse(true ,' التخصصات الدقيقة',compact('AccurateSpecialty'),200);
    }

}
