<?php

namespace App\Http\Tasks\Client\Settings;

use App\Http\Resources\API\YmtazSettings\YmtazWorkDaysResource;
use App\Http\Tasks\BaseTask;
use App\Models\YmtazSettings\YmtazWorkDays;
use Illuminate\Http\Request;

class ClientgetYmtazDatesTask extends BaseTask
{

    public function run(Request $request)
    {
        $availableDates = YmtazWorkDaysResource::collection(YmtazWorkDays::where('status',1)->orderBy('created_at','desc')->get());
        return $this->sendResponse(true, 'التواريخ المتاحة ل يمتاز ', compact('availableDates'), 200);
    }
}
