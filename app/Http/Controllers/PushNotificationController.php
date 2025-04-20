<?php
namespace App\Http\Controllers;

use App\Models\AccountFcm;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class PushNotificationController extends Controller
{
    public function sendPushNotification(Request $request)
    {
        $account_id = $request->account_id;
        $title = $request->title;
        $body = $request->body;
        $fcms = AccountFcm::where('account_id', $account_id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            \Log::info('test');
            $this->sendNotification($fcms, $title, $body, ["type" => 'global', "type_id" => null]);
        }

        return response()->json(['message' => 'Push notification sent successfully']);
    }


    public function sendNotification($fcms, $title, $body, $data = [])
    {

        $firebase = (new Factory)
            ->withServiceAccount(config_path('firebase_credentials.json'));

        $messaging = $firebase->createMessaging();

        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
        ])->withData($data);

        $messaging->sendMulticast($message, $fcms);
        return true;
    }
}
