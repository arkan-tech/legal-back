<?php

namespace App\Http\Tasks\Merged\ContactUs;

use App\Http\Tasks\BaseTask;
use App\Models\ContactYmtaz;
use Illuminate\Http\Request;

class GetContactUsRequestByIdTask extends BaseTask
{
    public function run(Request $request, $id)
    {
        $user = auth()->user();
        $isNotAccount = !auth()->guard("api_account")->check();
        if ($isNotAccount) {
            return $this->sendResponse(false, "Not allowed", null, 403);
        }
        $contactRequest = ContactYmtaz::where('account_id', '=', $user->id);
        $contactRequest = $contactRequest->with(['user', 'account'])->findOrFail($id);
        return $this->sendResponse(true, "Contact Us Request", compact('contactRequests'), 200);
    }
}
