<?php

namespace App\Http\Tasks\Lawyer\Profile;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\LawyerPayments;
use App\Models\Service\Service;
use App\Models\Client\ClientRequest;
use App\Models\Reservations\Reservation;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Models\ClientReservations\ClientReservations;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\Lawyer\LawyerWithServicesResource;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;

class LawyerGetAnalyticsTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = $this->authLawyer();
        $totalServicesCount = ClientRequest::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->count();
        $totalServicesCount = $totalServicesCount + LawyerServicesRequest::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->count();
        $pendingServicesCount = ClientRequest::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->whereIn('request_status', [1, 2])->count();
        $pendingServicesCount = $pendingServicesCount + LawyerServicesRequest::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->whereIn('request_status', [1, 2])->count();
        $lateServicesCount = ClientRequest::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->whereIn('request_status', [3, 4])->count();
        $lateServicesCount = $lateServicesCount + LawyerServicesRequest::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->whereIn('request_status', [3, 4])->count();
        $doneServicesCount = ClientRequest::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->where('request_status', 5)->count();
        $doneServicesCount = $doneServicesCount + LawyerServicesRequest::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->where('request_status', 5)->count();

        $totalAdvisoryServices = ClientAdvisoryServicesReservations::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->count();
        $totalAdvisoryServices = $totalAdvisoryServices + LawyerAdvisoryServicesReservations::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->count();
        $doneAdvisoryServices = ClientAdvisoryServicesReservations::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->where('reservation_status', 5)->count();
        $doneAdvisoryServices = $doneAdvisoryServices + LawyerAdvisoryServicesReservations::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->where('reservation_status', 5)->count();
        $lateAdvisoryServices = ClientAdvisoryServicesReservations::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->whereIn('reservation_status', [3, 4])->count();
        $lateAdvisoryServices = $lateAdvisoryServices + LawyerAdvisoryServicesReservations::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->whereIn('reservation_status', [3, 4])->count();
        $pendingAdvisoryServices = ClientAdvisoryServicesReservations::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->whereIn('reservation_status', [1, 2])->count();
        $pendingAdvisoryServices = $pendingAdvisoryServices + LawyerAdvisoryServicesReservations::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->whereIn('reservation_status', [1, 2])->count();

        $totalAppointments = Reservation::where('reserved_from_lawyer_id', $lawyer->id)->where('transaction_complete', 1)->count();
        $doneAppointments = Reservation::where('reserved_from_lawyer_id', $lawyer->id)->where('transaction_complete', 1)->where('reservationEnded', 1)->count();
        $today = Carbon::today();
        $lateAppointments = Reservation::where('reserved_from_lawyer_id', $lawyer->id)->where('transaction_complete', 1)->where('reservationEnded', 0)->where('to', '>', $today)->count();
        $pendingAppointments = Reservation::where('reserved_from_lawyer_id', $lawyer->id)->where('transaction_complete', 1)->where('reservationEnded', 0)->where('to', '<=', $today)->count();
        $payments = LawyerPayments::where('lawyer_id', $lawyer->id)->get();
        $pendingAction = 0;
        $pendingTransfer = 0;
        $transferred = 0;
        $total = 0;
        foreach ($payments as $payment) {
            if ($payment->paid == 1) {
                $transferred += $payment->product->price * 0.75;
            } else {
                if ($payment->payoutRequest()->exists()) {
                    $latestPayoutRequest = $payment->payoutRequest()->latest()->first();
                    if ($latestPayoutRequest->status == 1) {
                        $pendingTransfer += $payment->product->price * 0.75;
                    } else {
                        $pendingAction += $payment->product->price * 0.75;
                    }
                } else {
                    $pendingAction += $payment->product->price * 0.75;
                }
            }
        }
        $total = $pendingAction + $pendingTransfer + $transferred;
        $responseObject = [
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
            "wallet" => [
                'pendingAction' => $pendingAction,
                'pendingTransfer' => $pendingTransfer,
                'transferred' => $transferred,
                'total' => $total
            ]
        ];
        return $this->sendResponse(true, 'معلوماتي', $responseObject, 200);
    }
}
