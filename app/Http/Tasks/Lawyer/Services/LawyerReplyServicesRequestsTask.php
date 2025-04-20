<?php

namespace App\Http\Tasks\Lawyer\Services;

use App\Models\AccountFcm;
use App\Http\Tasks\BaseTask;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ServicesReservations;
use App\Http\Controllers\PushNotificationController;
use App\Http\Resources\ServicesReservationsResource;
use App\Http\Tasks\Lawyer\Services\LawyerReplyClientServicesRequestsTask;
use App\Http\Requests\API\Lawyer\Services\LawyerReplyServicesRequestsRequest;

class LawyerReplyServicesRequestsTask extends BaseTask
{
    public function run(LawyerReplyServicesRequestsRequest $request)
    {
        $lawyer = $this->authAccount();
        $reservation = ServicesReservations::findOrFail($request->request_id);

        if ($reservation->reserved_from_lawyer_id != $lawyer->id) {
            return $this->sendResponse(false, 'Unauthorized access.', null, 403);
        }

        $reservation->update([
            'replay_status' => 1,
            'request_status' => 5,
            'replay' => $request->reply_content,
            'replay_time' => now()->format('H:i:s'),
            'replay_date' => now()->format('Y-m-d'),
        ]);

        // Save files if present
        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = saveImage($file, 'uploads/services-requests/');
                $reservation->files()->create(['file' => $filePath, 'is_reply' => 1]);
            }
        }

        // Save voice file if present
        if ($request->hasFile('voice_file')) {
            $voiceFilePath = saveImage($request->file('voice_file'), 'uploads/services-requests/');
            $reservation->files()->create(['file' => $voiceFilePath, 'is_reply' => 1, 'is_voice' => 1]);
        }

        // Send notification to the client
        $notification = Notification::create([
            'title' => 'You have a reply to your service request',
            'description' => 'Your service request has been replied.',
            'type' => 'service_request_reply',
            'type_id' => $reservation->id,
            'account_id' => $reservation->account_id,
        ]);

        $fcms = AccountFcm::where('account_id', $reservation->account_id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            $notificationController = new PushNotificationController;
            $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
        }

        $reservationResource = new ServicesReservationsResource($reservation);
        return $this->sendResponse(true, 'Reply sent successfully.', compact('reservationResource'), 200);
    }
}
