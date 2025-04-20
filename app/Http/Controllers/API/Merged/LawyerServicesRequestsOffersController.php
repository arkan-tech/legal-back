<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Models\ServiceRequestOffer;
use App\Models\ServicesReservations;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ServiceRequestOfferResource;
use App\Models\Notification;
use App\Models\AccountFcm;
use App\Http\Controllers\PushNotificationController;

class LawyerServicesRequestsOffersController extends BaseController
{
    public function getPendingRequests()
    {
        $lawyer = $this->authAccount();

        $offers = ServiceRequestOffer::where('lawyer_id', $lawyer->id)->whereNot('status', 'accepted')
            ->with('service', 'importance', 'account', 'lawyer', 'files')
            ->get()
            ->groupBy('status');


        $groupedOffers = [
            'pending-acceptance' => [],
            'pending-offer' => [],
            'cancelled-by-client' => [],
        ];
        foreach ($offers as $status => $offerGroup) {
            $groupedOffers[$status] = ServiceRequestOfferResource::collection($offerGroup);
        }
        return $this->sendResponse(true, 'Pending offers fetched successfully.', ['offers' => $groupedOffers], 200);
    }

    public function addOffer(Request $request)
    {
        $lawyer = $this->authAccount();

        $offer = ServiceRequestOffer::where('id', $request->id)
            ->where('lawyer_id', $lawyer->id)
            ->where('status', 'pending-offer')
            ->first();

        if (!$offer) {
            return $this->sendResponse(false, 'Unauthorized access.', null, 403);
        }

        $offer->price = $request->price;
        $offer->status = 'pending-acceptance';
        $offer->save();

        // Notify client about the new offer
        $notification = Notification::create([
            'title' => "عرض جديد",
            "description" => "تم تقديم عرض جديد من المحامي.",
            "type" => "service-offer",
            "type_id" => $offer->id,
            "account_id" => $offer->account_id,
        ]);
        $fcms = AccountFcm::where('account_id', $notification->account_id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            $notificationController = new PushNotificationController;
            $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
        }

        return $this->sendResponse(true, 'Offer updated successfully.', ['offer' => $offer], 200);
    }
}
