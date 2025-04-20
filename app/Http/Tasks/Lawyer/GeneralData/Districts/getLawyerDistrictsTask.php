<?php

namespace App\Http\Tasks\Lawyer\GeneralData\Districts;

use App\Http\Resources\API\Lawyer\GeneralData\Districts\LawyerDistrictsResource;
use App\Http\Tasks\BaseTask;
use App\Models\City\City;
use App\Models\Districts\Districts;


class getLawyerDistrictsTask extends BaseTask
{
    public function run()
    {
        $Districts = LawyerDistrictsResource::collection(Districts::where('status', 1)->orderBy('created_at','desc')->get());
        return $this->sendResponse(true, ' الاحياء', compact('Districts'), 200);
    }

}
