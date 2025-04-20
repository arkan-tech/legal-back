<?php

namespace App\Http\Tasks\Lawyer\GeneralData\Degrees;

use App\Http\Resources\API\Lawyer\GeneralData\Degrees\LawyerDegreesResource;
use App\Http\Tasks\BaseTask;
use App\Models\Degree\Degree;

class getLawyerDegreesTask extends BaseTask
{
    public function run()
    {
        $Degrees = LawyerDegreesResource::collection(Degree::where('isYmtaz', 1)->where('status', 1)->orderBy('created_at', 'desc')->get());
        return $this->sendResponse(true, '  الدرجات العلمية', compact('Degrees'), 200);
    }

}
