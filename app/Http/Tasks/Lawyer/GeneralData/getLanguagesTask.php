<?php

namespace App\Http\Tasks\Lawyer\GeneralData;

use App\Http\Resources\API\Lawyer\LawyerLanguageResource;
use App\Http\Tasks\BaseTask;
use App\Models\Country\Country;
use App\Models\Country\Nationality;
use App\Models\Language;
use App\Models\Lawyer\LawyerType;

class getLanguagesTask extends BaseTask
{
    public function run(){
        $languages = LawyerLanguageResource::collection(Language::orderBy('id','asc')->get());
        return $this->sendResponse(true ,'اللغات',compact('languages'),200);
    }

}
