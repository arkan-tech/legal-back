<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Models\MailerAccounts;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\SubscribeMailerRequest;
use App\Http\Requests\UnSubscribeMailerRequest;

class MailerController extends BaseController
{
    public function subscribe(SubscribeMailerRequest $request, MailerAccounts $mailer)
    {
        $mailer = MailerAccounts::where('email', $request->email)->first();
        if ($mailer) {
            $mailer->subscribe();
            return $this->sendResponse(true, 'Subscribed successfully', null, 200);
        } else {
            $mailer = new MailerAccounts();
            $mailer->email = $request->email;
            $mailer->subscribe();
            return $this->sendResponse(true, 'Subscribed successfully', null, 200);
        }

    }

    public function unsubscribe(UnSubscribeMailerRequest $request, MailerAccounts $mailer)
    {
        $mailer = MailerAccounts::where('email', $request->email)->first();
        $mailer->unsubscribe();
        return $this->sendResponse(true, 'Unsubscribed successfully', null, 200);

    }
}
