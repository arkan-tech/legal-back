<?php

namespace App\Http\Tasks\Lawyer\GeneralData\Cities;

use App\Http\Resources\API\Lawyer\GeneralData\Cities\LawyerCitiesResource;
use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerRegionsResource;
use App\Http\Tasks\BaseTask;
use App\Models\City\City;
use App\Models\Districts\Districts;
use App\Models\Regions\Regions;

class getLawyerCitiesTask extends BaseTask
{
    public function run()
    {
        $Cities = LawyerCitiesResource::collection(City::where('status', 1)->get());
        return $this->sendResponse(true, ' المدن', compact('Cities'), 200);
    }

}
