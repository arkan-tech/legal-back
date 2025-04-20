<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices\RequestedFromLawyer;

use App\Models\Devices\LawyerFcmDevice;
use Exception;
use App\Http\Tasks\BaseTask;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Devices\ClientFcmDevice;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Http\Controllers\PushNotificationController;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationResource;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\Lawyer\LawyerCreateReservationLawyerRequest;

class LawyerReplyLawyerAdvisoryServiceTask extends BaseTask
{

    public function run(Request $request)
    {
        $Lawyer = $this->authLawyer();
        $reservation = LawyerAdvisoryServicesReservations::with('lawyer')->find($request->id);
        if ($reservation->lawyer->id != $Lawyer->id) {
            return $this->sendResponse(true, 'Insufficient Permissions to request', null, 403);
        }
        $reservation->update([
            'replay_status' => 1,
            'replay_subject' => $request->reply_subject,
            'replay_content' => $request->reply_content,
            'reservation_status' => 5,

            'replay_time' => date("h:i:s"),
            'replay_date' => date("Y-m-d"),
        ]);
        if ($request->has('reply_file')) {
            $reservation->update([
                'replay_file' => saveImage($request->reply_file, 'uploads/advisory_services/replay_file/reservations/')
            ]);
        }
        $notification = Notification::create([
            'title' => "لديك رد على استشارة",
            "description" => "تم الرد على الاستشارة",
            "type" => "advisory_service",
            "type_id" => $reservation->id,
            "userType" => "lawyer",
            "lawyer_id" => $reservation->reserved_lawyer_id,
        ]);
        $fcms = LawyerFcmDevice::where('lawyer_id', $reservation->reserved_lawyer_id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            $notificationController = new PushNotificationController;
            $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
        }
        $reservation = new LawyerAdvisoryServicesReservationResource($reservation);
        return $this->sendResponse(true, '', compact('reservation'), 200);

    }
}
