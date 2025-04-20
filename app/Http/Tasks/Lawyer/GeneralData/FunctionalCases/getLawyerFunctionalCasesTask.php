<?php

namespace App\Http\Tasks\Lawyer\GeneralData\FunctionalCases;

use App\Http\Resources\API\Lawyer\GeneralData\FunctionalCases\LawyerFunctionalCasesResource;
use App\Http\Resources\API\Lawyer\GeneralData\LawyerDegreestResource;
use App\Http\Tasks\BaseTask;
use App\Models\Degree\Degree;
use App\Models\FunctionalCases\FunctionalCases;
use App\Models\Specialty\AccurateSpecialty;

class getLawyerFunctionalCasesTask extends BaseTask
{
    public function run(){
        $FunctionalCases = LawyerFunctionalCasesResource::collection(FunctionalCases::where('status',1)->orderBy('created_at','desc')->get());
        return $this->sendResponse(true ,' الحالات الوظيفية',compact('FunctionalCases'),200);
    }

}
