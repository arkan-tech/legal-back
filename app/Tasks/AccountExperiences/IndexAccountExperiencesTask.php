<?php

namespace App\Tasks\AccountExperiences;

use App\Http\Resources\AccountExperienceResource;
use App\Http\Tasks\BaseTask;
use App\Models\AccountExperience;

class IndexAccountExperiencesTask extends BaseTask
{
    public function run()
    {
        $accountId = $this->authAccount()->id;
        $account_experiences = AccountExperience::where('account_id', $accountId)->get();
        $account_experiences = AccountExperienceResource::collection($account_experiences);

        return $this->sendResponse(
            true,
            'Account experiences retrieved successfully',
            compact('account_experiences'),
            200
        );
    }
}
