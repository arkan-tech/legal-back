<?php

namespace App\Http\Tasks\Merged\ContactUs;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;

class GetContactsTypesTask extends BaseTask
{
    public function run(Request $request)
    {
        $user = auth()->user();

        if (!auth()->guard("api_account")->check()) {
            return $this->sendResponse(false, "Not allowed", null, 403);
        }
        $contactTypes = [
            [
                "id" => 1,
                "name" => "اقتراح"
            ],
            [
                "id" => 2,
                "name" => "شكوى"
            ],
            [
                "id" => 3,
                "name" => "اخرى"
            ]
        ];
        return $this->sendResponse(true, "Contact Us Types", compact('contactTypes'), 200);

    }
}
