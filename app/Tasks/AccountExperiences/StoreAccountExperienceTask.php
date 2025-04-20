<?php

namespace App\Tasks\AccountExperiences;

use Carbon\Carbon;
use App\Http\Tasks\BaseTask;
use App\Models\AccountExperience;
use App\Http\Resources\AccountExperienceResource;
use App\Http\Requests\StoreAccountExperiencesRequest;

class StoreAccountExperienceTask extends BaseTask
{
    public function run(StoreAccountExperiencesRequest $data)
    {
        $accountId = $this->authAccount()->id;

        // Delete old experiences
        AccountExperience::where('account_id', $accountId)->delete();

        // Create new experiences
        foreach ($data->all() as $experience) {
            $from = Carbon::parse($experience['from']);
            $to = isset($experience['to']) ? Carbon::parse($experience['to']) : null;
            AccountExperience::create([
                'account_id' => $accountId,
                'title' => $experience['title'],
                'company' => $experience['company'],
                'from' => $from,
                'to' => $to,
            ]);
        }

        $account_experiences = AccountExperience::where('account_id', $accountId)->get();
        $account_experiences = AccountExperienceResource::collection($account_experiences);
        return $this->sendResponse(true, 'Experiences stored successfully.', compact('account_experiences'), 200);
    }
}
