<?php

namespace App\Http\Tasks\Lawyer\GeneralData\Regions;

use App\Http\Resources\API\Lawyer\GeneralData\Countries\LawyerCountriesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerRegionsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Country\Country;
use App\Models\Regions\Regions;

class getLawyerRegionsTask extends BaseTask
{
    public function run()
    {
        $Regions = LawyerRegionsResource::collection(Regions::where('status', 1)->get());
        return $this->sendResponse(true, ' المناطق', compact('Regions'), 200);
    }

}
