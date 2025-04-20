<?php

namespace App\Http\Tasks\Merged\Reservations;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\AccountFcm;
use App\Http\Tasks\BaseTask;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\LawyerPayments;
use App\Models\API\Splash\Splash;
use App\Models\LawyerPayoutRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\Devices\ClientFcmDevice;
use App\Models\Devices\LawyerFcmDevice;
use App\Models\Reservations\Reservation;
use App\Models\Reservations\ReservationType;
use App\Http\Requests\BookReservationRequest;
use App\Models\Reservations\ReservationRequest;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Controllers\PushNotificationController;
use App\Models\Reservations\ReservationTypeImportance;
use App\Http\Resources\API\Reservations\ReservationResource;
use App\Http\Resources\API\Reservations\ReservationResourceCode;
use App\Http\Resources\API\Reservations\ReservationRequestResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\Reservations\ReservationResourceCodeFromReservation;

class GetReservationRequestsTask extends BaseTask
{

    public function run(Request $request)
    {

        $user = $this->authAccount();
        // $perPage = $request->get('per_page', 15); // Default to 15 items per page
        $offers = ReservationRequest::where('account_id', $user->id)
            ->with('lawyer', 'reservationType', 'account', 'importance', 'reservation')
            // ->paginate($perPage)
            ->get()
            ->groupBy('status');

        $groupedOffers = [
            'accepted' => [],
            'pending-acceptance' => [],
            'pending-offer' => [],
            'cancelled-by-client' => [],
        ];
        foreach ($offers as $status => $offerGroup) {
            if ($status == 'accepted') {
                $groupedOffers[$status] = ReservationResourceCodeFromReservation::collection($offerGroup);
            } else {

                $groupedOffers[$status] = ReservationRequestResource::collection($offerGroup);
            }
        }

        return $this->sendResponse(true, 'Offers fetched successfully.', ['offers' => $groupedOffers], 200);

    }

}
