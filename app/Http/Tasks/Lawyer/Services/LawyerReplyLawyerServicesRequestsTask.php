<?php

namespace App\Http\Tasks\Lawyer\Services;

use App\Http\Tasks\BaseTask;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Models\Devices\LawyerFcmDevice;
use App\Http\Controllers\PushNotificationController;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Models\LawyerServicesRequest\LawyerServicesRequestRates;
use App\Http\Requests\API\Lawyer\Services\LawyerRateServicesRequestsRequest;
use App\Http\Requests\API\Lawyer\Services\LawyerReplyServicesRequestsRequest;

class LawyerReplyLawyerServicesRequestsTask extends BaseTask
{

    public function run(LawyerReplyServicesRequestsRequest $request)
    {
        $lawyer = $this->authLawyer();
        $reservation = LawyerServicesRequest::where('lawyer_id', $lawyer->id)->where('id', $request->request_id)->with('client')->first();
        if (is_null($reservation)) {
            return $this->sendResponse(false, '! الطلب غير موجود ', null, 404);
        }
        if ($reservation->replay_status == 1) {
            return $this->sendResponse(false, 'تم الرد على الطلب مسبقا', null, 400);
        }
        $reply = $reservation->update([
            'replay' => $request->reply,
            'replay_status' => 1,
            'request_status' => 5,
            'replay_date' => date('Y-m-d'),
            'replay_time' => date('h:i'),
            'replay_from_lawyer_id' => $lawyer->id

        ]);
        $bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
        $bodyMessage1 = ' لديك رد على الخدمة التي طلبتها و هو :';
        $bodyMessage2 = $request->reply;
        $bodyMessage3 = '';
        $data = [
            'name' => $reservation->client->name,
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
            "userType" => "lawyer",
            "lawyer_id" => $reservation->request_lawyer_id,
        ]);
        $fcms = LawyerFcmDevice::where('lawyer_id', $reservation->request_lawyer_id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            $notificationController = new PushNotificationController;
            $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
        }
        return $this->sendResponse(true, 'تم الرد على الخدمة بنجاح', null, 200);
    }
}
