<?php

namespace App\Http\Tasks\Merged\ContactUs;

use App\Models\Activity;
use App\Http\Tasks\BaseTask;
use App\Models\ContactYmtaz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\Merged\CreateContactUsRequest;

class CreateContactRequest extends BaseTask
{
    public function run(CreateContactUsRequest $request)
    {
        $user = null;
        if (Auth::guard("api_account")->check()) {
            $user = Auth::guard("api_account")->user();
        }

        $contactUsRequest = ContactYmtaz::create([
            "account_id" => is_null($user) ? null : $user->id,
            "name" => !is_null($user) ? null : $request->name,
            "email" => !is_null($user) ? null : $request->email,
            "type" => $request->type,
            "subject" => $request->subject,
            "details" => $request->details,
        ]);
        if (!is_null($user)) {
            if ($contactUsRequest->type == 1) {
                $activity = Activity::find(3);
                $user->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);
            } else if ($contactUsRequest->type == 2) {
                $activity = Activity::find(4);
                $user->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);
            }
        }
        if ($request->has('file')) {
            $contactUsRequest->file = saveImage($request->file('file'), 'uploads/contact_ymtaz/');
            $contactUsRequest->save();
        }
        $contactUsRequest->with(['user', 'account']);
        return $this->sendResponse(true, "Contact Us Request Submitted Successfully", $contactUsRequest, 201);


    }
}
