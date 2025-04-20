<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices\RequestedFromLawyer;

use Exception;
use App\Models\AccountFcm;
use App\Http\Tasks\BaseTask;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Devices\ClientFcmDevice;
use App\Models\AdvisoryServicesReservations;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Http\Controllers\PushNotificationController;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationsRates;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationResource;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\Lawyer\LawyerCreateReservationLawyerRequest;
use App\Http\Requests\API\Lawyer\LawyerAdvisoryService\Lawyer\LawyerReplyClientAdvisoryServiceRequest;

class LawyerReplyClientAdvisoryServiceTask extends BaseTask
{

    public function run(LawyerReplyClientAdvisoryServiceRequest $request)
    {
        $Lawyer = $this->authAccount();
        $reservation = AdvisoryServicesReservations::with('lawyer')->find($request->id);
        if ($reservation->lawyer->id != $Lawyer->id) {
            return $this->sendResponse(true, 'Insufficient Permissions to request', null, 403);
        }
        $reservation->update([
            'replay_status' => 1,
            'request_status' => 5,
            'replay_subject' => $request->reply_subject,
            'replay_content' => $request->reply_content,
            'reservation_status' => 5,
            'replay_time' => date("h:i:s"),
            'replay_date' => date("Y-m-d"),
        ]);

        // Save files if present
        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = saveImage($file, 'uploads/advisory_services/reservations/');
                // Attach the file path to the reservation
                $reservation->files()->create(['file' => $filePath, 'is_reply' => 1]);
            }
        }

        // Save voice file if present
        if ($request->hasFile('voice_file')) {
            $voiceFilePath = saveImage($request->file('voice_file'), 'uploads/advisory_services/reservations/');
            $reservation->files()->create(['file' => $voiceFilePath, 'is_reply' => 1, 'is_voice' => 1]);
        }

        $notification = Notification::create([
            'title' => "لديك رد على استشارة",
            "description" => "تم الرد على الاستشارة",
            "type" => "advisory_service",
            "type_id" => $reservation->id,
            "account_id" => $reservation->account_id,
        ]);
        $fcms = AccountFcm::where('account_id', $reservation->account_id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            $notificationController = new PushNotificationController;
            $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
        }
        $reservation = new AdvisoryServicesReservationResource($reservation);
        return $this->sendResponse(true, '', compact('reservation'), 200);

    }
}
