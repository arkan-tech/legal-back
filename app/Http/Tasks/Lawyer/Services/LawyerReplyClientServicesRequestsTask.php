<?php

namespace App\Http\Tasks\Lawyer\Services;

use App\Http\Tasks\BaseTask;
use App\Models\Devices\ClientFcmDevice;
use App\Models\Notification;
use App\Models\Client\ClientRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\Devices\LawyerFcmDevice;
use App\Models\Client\ClientRequestReplies;
use App\Http\Controllers\PushNotificationController;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Models\LawyerServicesRequest\LawyerServicesRequestRates;
use App\Http\Requests\API\Lawyer\Services\LawyerRateServicesRequestsRequest;
use App\Http\Requests\API\Lawyer\Services\LawyerReplyServicesRequestsRequest;

class LawyerReplyClientServicesRequestsTask extends BaseTask
{

    public function run(LawyerReplyServicesRequestsRequest $request)
    {
        $lawyer = $this->authLawyer();
        $reservation = ClientRequest::where('lawyer_id', $lawyer->id)->where('id', $request->request_id)->with(['client', 'replies'])->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, '! الطلب غير موجود ', null, 404);
        }
        if ($reservation->replay_status == 1) {
            return $this->sendResponse(false, 'تم الرد على الطلب مسبقا', null, 400);
        }
        $reply = $reservation->update([
            'replay_status' => 1,
            'request_status' => 5,
            'replay_date' => date('Y-m-d'),
            'replay_time' => date('h:i'),
            'replay' => $request->reply,
            'replay_lawyer_id' => $lawyer->id
        ]);
        // $reply = ClientRequestReplies::create([
        //     'client_requests_id' => $reservation->id,
        //     'replay' => $request->reply,
        //     'replay_lawyer_id' => $lawyer->id

        // ]);
        $bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
        $bodyMessage1 = ' لديك رد على الخدمة التي طلبتها و هو :';
        $bodyMessage2 = $request->reply;
        $bodyMessage3 = '';
        $data = [
            'name' => $reservation->client->myname,
            'email' => ($reservation->client->email),
            'subject' => " رد على طلب خدمة . ",
            'bodyMessage' => $bodyMessage,
            'bodyMessage1' => $bodyMessage1,
            'bodyMessage2' => $bodyMessage2,
            'bodyMessage3' => $bodyMessage3,
            'platformLink' => env('REACT_WEB_LINK'),

        ];
        Mail::send(
            'email',
            $data,
            function ($message) use ($data) {
                $message->from('ymtaz@ymtaz.sa');
                $message->to($data['email'], $data['name'])->subject($data['subject']);
            }
        );
        if ($request->has('file')) {
            $file = saveImage($request->file('file'), 'uploads/client/service_request');
            $reply = $reservation->update([
                'replay_file' => $file
            ]);
        }
        $notification = Notification::create([
            'title' => "لديك رد على خدمة",
            "description" => "تم الرد على الخدمة",
            "type" => "service",
            "type_id" => $reservation->id,
            "userType" => "client",
            "service_user_id" => $reservation->client_id,
        ]);
        $fcms = ClientFcmDevice::where('client_id', $reservation->client_id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            $notificationController = new PushNotificationController;
            $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
        }

        return $this->sendResponse(true, 'تم الرد على الخدمة بنجاح', null, 200);
    }
}
