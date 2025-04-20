<?php

namespace App\Http\Tasks\Merged;

use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Http\Tasks\BaseTask;
use App\Models\ContactYmtaz;
use Illuminate\Http\Request;
use App\Http\Requests\API\Merged\CreateContactUsRequest;

class GetActivitiesTask extends BaseTask
{
    public function run(Request $request)
    {
        $activities = Activity::get();
        $activities = ActivityResource::collection($activities);
        return $this->sendResponse(true, "Fetch Activities", compact('activities'), 200);


    }
}
