<?php

namespace App\Http\Tasks\Merged\Profile;

use Carbon\Carbon;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientRequest;
use App\Models\ServicesReservations;
use App\Models\Reservations\Reservation;
use App\Models\AdvisoryServicesReservations;
use App\Http\Resources\ServicesReservationsResource;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\Reservations\ReservationResource;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationReply;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationResource;

class GetMyPageTask extends BaseTask
{

    public function run()
    {

        // dd('test');
        $user = auth()->user();
        $today = Carbon::today();

        $reservations = Reservation::with([
            'reservationType'
        ])->where('account_id', $user->id)->where('transaction_complete', 1)->limit(10)->get()->sortDesc();
        $reservations = ReservationResource::collection($reservations);
        $advisoryServicesBooked = AdvisoryServicesReservations::where(['account_id' => $user->id, 'replay_status' => 0])->with(["subCategoryPrice.importance", 'subCategoryPrice.subCategory'])->limit(10)->get()->sortDesc();
        $advisoryServicesBooked = AdvisoryServicesReservationResource::collection($advisoryServicesBooked);
        $services = ServicesReservations::where(['account_id' => $user->id, 'replay_status' => 0])->limit(10)->get()->sortDesc();
        $services = ServicesReservationsResource::collection($services);

        //Analytics services
        $totalServicesCount = ServicesReservations::where('account_id', $user->id)->where('transaction_complete', 1)->count();
        $pendingServicesCount = ServicesReservations::where('account_id', $user->id)->where('transaction_complete', 1)->whereIn('request_status', [1, 2])->count();
        $lateServicesCount = ServicesReservations::where('account_id', $user->id)->where('transaction_complete', 1)->whereIn('request_status', [3, 4])->count();
        $doneServicesCount = ServicesReservations::where('account_id', $user->id)->where('transaction_complete', 1)->where('request_status', 5)->count();

        //Analytics AdvisoryServices
        $totalAdvisoryServices = AdvisoryServicesReservations::where('account_id', $user->id)->where('transaction_complete', 1)->count();
        $doneAdvisoryServices = AdvisoryServicesReservations::where('account_id', $user->id)->where('transaction_complete', 1)->where('request_status', 5)->count();
        $lateAdvisoryServices = AdvisoryServicesReservations::where('account_id', $user->id)->where('transaction_complete', 1)->whereIn('request_status', [3, 4])->count();
        $pendingAdvisoryServices = AdvisoryServicesReservations::where('account_id', $user->id)->where('transaction_complete', 1)->whereIn('request_status', [1, 2])->count();

        //Analytics Appointments
        $totalAppointments = Reservation::where('account_id', $user->id)->where('transaction_complete', 1)->count();
        $doneAppointments = Reservation::where('account_id', $user->id)->where('transaction_complete', 1)->where('reservation_started', 1)->count();
        $pendingAppointments = Reservation::where('account_id', $user->id)->where('transaction_complete', 1)->where('reservation_started', 0)->where('to', '<=', $today)->count();

        $myPageData = [
            "reservations" => $reservations,
            "advisoryServices" => $advisoryServicesBooked,
            "services" => $services,
            "analytics" => [
                "services" => [
                    "total" => $totalServicesCount,
                    "done" => $doneServicesCount,
                    "pending" => $pendingServicesCount,
                    "late" => $lateServicesCount,
                ],
                "advisoryServices" => [
                    "total" => $totalAdvisoryServices,
                    "done" => $doneAdvisoryServices,
                    "pending" => $pendingAdvisoryServices,
                    "late" => $lateAdvisoryServices,
                ],
                "appointments" => [
                    "total" => $totalAppointments,
                    "done" => $doneAppointments,
                    "pending" => $pendingAppointments,
                ],
            ]
        ];

        return $this->sendResponse(true, 'My page data', $myPageData, 200);
    }
}
