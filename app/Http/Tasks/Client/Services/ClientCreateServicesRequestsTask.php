<?php

namespace App\Http\Tasks\Client\Services;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\AccountFcm;
use App\Http\Tasks\BaseTask;
use App\Models\Notification;
use App\Models\LawyerPayments;
use App\Models\Service\Service;
use App\Models\ServiceRequestOffer;
use App\Models\Client\ClientRequest;
use App\Models\ServicesReservations;
use App\Models\Service\ServicesRequest;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\Service\ServiceYmtazLevelPrices;
use App\Models\ServicesRequestsAndReservationsFile;
use App\Http\Controllers\PushNotificationController;
use App\Http\Resources\ServicesReservationsResource;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Http\Requests\API\Client\Services\ClientCreateServicesRequestsRequest;

class ClientCreateServicesRequestsTask extends BaseTask
{

    public function run(ClientCreateServicesRequestsRequest $request)
    {
        $client = $this->authAccount();
        // dd($client);
        $serviceId = $request->service_id;
        $priority = $request->importance_id;
        $description = $request->description;
        $acceptRules = $request->accept_rules;
        $lawyerIds = $request->lawyer_ids;
        $serviceRequests = [];

        foreach ($lawyerIds as $lawyerId) {
            // Create a service request for each lawyer
            $serviceRequest = ServiceRequestOffer::create([
                'account_id' => $client->id,
                'service_id' => $serviceId,
                'importance_id' => $priority,
                'description' => $description,
                'lawyer_id' => $lawyerId,
                'status' => 'pending-offer',
            ]);

            // Save multiple files if provided
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filePath = saveImage($file, 'uploads/services-requests');
                    $serviceRequest->files()->create([
                        'file' => $filePath,
                    ]);
                }
            }

            // Save voice file if provided
            if ($request->hasFile('voice_file')) {
                $filePath = saveImage($request->file('voice_file'), 'uploads/services-requests');
                $serviceRequest->files()->create([
                    'file' => $filePath,
                    'is_voice' => true,
                ]);
            }

            $serviceRequests[] = $serviceRequest;

            $notification = Notification::create([
                'title' => "طلب حجز خدمة",
                "description" => "تم تلقي طلب خدمة من طالب خدمة وبأنتظاز التسعير",
                "type" => "service-lawyer",
                "type_id" => $serviceRequest->id,
                "account_id" => $serviceRequest->lawyer_id,
            ]);
            $fcms = AccountFcm::where('account_id', $notification->account_id)->pluck('fcm_token')->toArray();
            if (count($fcms) > 0) {
                $notificationController = new PushNotificationController;
                $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
            }
        }
        $notification = Notification::create([
            'title' => "طلب حجز خدمة من مقدم خدمة",
            "description" => "تم طلب حجز خدمة من مقدم خدمة لك بنجاح",
            "type" => "service",
            "type_id" => $serviceRequest->id,
            "account_id" => $client->id,
        ]);
        $fcms = AccountFcm::where('account_id', $notification->account_id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            $notificationController = new PushNotificationController;
            $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
        }

        return [
            'status' => true,
            'message' => 'Service requests created successfully.',
            'data' => ['service_requests' => $serviceRequests],
            'code' => 201,
        ];
    }
    protected function isTimeSlotReserved($start, $end, $date, $lawyer_id)
    {
        $reservations = ServicesReservations::where('day', $date)->where('reserved_from_lawyer_id', $lawyer_id)->get();
        \Illuminate\Support\Facades\Log::info('Checking time slot reservation', [
            'start' => $start->format('Y-m-d H:i:s'),
            'end' => $end->format('Y-m-d H:i:s'),
            'reservation_count' => $reservations->count(),
        ]);
        foreach ($reservations as $reservation) {
            $resFrom = Carbon::parse($date . ' ' . Carbon::parse($reservation->from)->format('H:i:s'));
            $resTo = Carbon::parse($date . ' ' . Carbon::parse($reservation->to)->format('H:i:s'));
            $isBetween = $start->between($resFrom, $resTo) || $end->between($resFrom, $resTo) || $resFrom->between($start, $end) || $resTo->between($start, $end);
            \Illuminate\Support\Facades\Log::info('Checking against reservation', [
                'res_from' => $resFrom->format('Y-m-d H:i:s'),
                'res_to' => $resTo->format('Y-m-d H:i:s'),
            ]);
            if ($isBetween) {
                if ($reservation->transaction_complete != 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
