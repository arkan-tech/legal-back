<?php

namespace App\Http\Tasks\Merged\ContactUs;

use App\Http\Tasks\BaseTask;
use App\Models\ContactYmtaz;
use Illuminate\Http\Request;

class GetContactUsRequestsTask extends BaseTask
{
    public function run(Request $request)
    {
        $user = auth()->user();
        $isNotAccount = !auth()->guard("api_account")->check();
        if ($isNotAccount) {
            return $this->sendResponse(false, "Not allowed", null, 403);
        }
        $contactRequests = ContactYmtaz::where("account_id", $user->id);

        $contactRequests = $contactRequests->with(['user', 'account'])->get();
        return $this->sendResponse(true, "Contact Us Requests", compact('contactRequests'), 200);

    }
}
