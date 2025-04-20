<?php

namespace App\Http\Tasks\Merged\Profile;

use App\Models\AdvisoryServicesReservations;
use App\Models\ServicesReservations;
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

class GetAnalyticsTask extends BaseTask
{

    public function run(Request $request)
    {
        $account = auth()->user();
        $totalServicesCount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->count();
        $totalServicesCount = $totalServicesCount + ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->count();
        $pendingServicesCount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [1, 2])->count();
        $pendingServicesCount = $pendingServicesCount + ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [1, 2])->count();
        $lateServicesCount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [3, 4])->count();
        $lateServicesCount = $lateServicesCount + ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [3, 4])->count();
        $doneServicesCount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('request_status', 5)->count();
        $doneServicesCount = $doneServicesCount + ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('request_status', 5)->count();

        $totalAdvisoryServices = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->count();
        $totalAdvisoryServices = $totalAdvisoryServices + AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->count();
        $doneAdvisoryServices = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('request_status', 5)->count();
        $doneAdvisoryServices = $doneAdvisoryServices + AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('request_status', 5)->count();
        $lateAdvisoryServices = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [3, 4])->count();
        $lateAdvisoryServices = $lateAdvisoryServices + AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [3, 4])->count();
        $pendingAdvisoryServices = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [1, 2])->count();
        $pendingAdvisoryServices = $pendingAdvisoryServices + AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [1, 2])->count();

        $totalAppointments = Reservation::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->count();
        $doneAppointments = Reservation::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('reservation_started', 1)->count();
        $today = Carbon::today();
        $lateAppointments = Reservation::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('reservation_started', 0)->where('to', '>', $today)->count();
        $pendingAppointments = Reservation::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('reservation_started', 0)->where('to', '<=', $today)->count();
        $payments = LawyerPayments::where('account_id', $account->id)->get();
        $pendingAction = 0;
        $pendingTransfer = 0;
        $transferred = 0;
        $total = 0;
        foreach ($payments as $payment) {
            if ($payment->paid == 1) {
                $transferred += ($payment->product->price ?? 0) * 0.75;
            } else {
                if ($payment->payoutRequest()->exists()) {
                    $latestPayoutRequest = $payment->payoutRequest()->latest()->first();
                    if ($latestPayoutRequest->status == 1) {
                        $pendingTransfer += ($payment->product->price ?? 0) * 0.75;
                    } else {
                        $pendingAction += ($payment->product->price ?? 0) * 0.75;
                    }
                } else {
                    $pendingAction += ($payment->product->price ?? 0) * 0.75;
                }
            }
        }
        $total = $pendingAction + $pendingTransfer + $transferred;

        $lastMonth = Carbon::now()->subMonth();
        $currentMonth = Carbon::now();

        $lastMonthServicesCount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$lastMonth->startOfMonth()->toISOString(), $lastMonth->endOfMonth()->toISOString()])
            ->count();

        $currentMonthServicesCount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$currentMonth->startOfMonth()->toISOString(), $currentMonth->endOfMonth()->toISOString()])
            ->count();

        $servicesPercentageChange = $this->calculatePercentageChange($lastMonthServicesCount, $currentMonthServicesCount);
        $servicesChangeDirection = $this->calculateChangeDirection($lastMonthServicesCount, $currentMonthServicesCount);

        $lastMonthAdvisoryServicesCount = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$lastMonth->startOfMonth()->toISOString(), $lastMonth->endOfMonth()->toISOString()])
            ->count();

        $currentMonthAdvisoryServicesCount = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$currentMonth->startOfMonth()->toISOString(), $currentMonth->endOfMonth()->toISOString()])
            ->count();

        $advisoryServicesPercentageChange = $this->calculatePercentageChange($lastMonthAdvisoryServicesCount, $currentMonthAdvisoryServicesCount);
        $advisoryServicesChangeDirection = $this->calculateChangeDirection($lastMonthAdvisoryServicesCount, $currentMonthAdvisoryServicesCount);

        $lastMonthAppointmentsCount = Reservation::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$lastMonth->startOfMonth()->toISOString(), $lastMonth->endOfMonth()->toISOString()])
            ->count();

        $currentMonthAppointmentsCount = Reservation::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$currentMonth->startOfMonth()->toISOString(), $currentMonth->endOfMonth()->toISOString()])
            ->count();

        $appointmentsPercentageChange = $this->calculatePercentageChange($lastMonthAppointmentsCount, $currentMonthAppointmentsCount);
        $appointmentsChangeDirection = $this->calculateChangeDirection($lastMonthAppointmentsCount, $currentMonthAppointmentsCount);

        $totalServicesAmount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->sum('price');
        $doneServicesAmount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('request_status', 5)->sum('price');
        $pendingServicesAmount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [1, 2])->sum('price');
        $lateServicesAmount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [3, 4])->sum('price');

        $lastMonthServicesAmount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$lastMonth->startOfMonth()->toISOString(), $lastMonth->endOfMonth()->toISOString()])
            ->sum('price');

        $currentMonthServicesAmount = ServicesReservations::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$currentMonth->startOfMonth()->toISOString(), $currentMonth->endOfMonth()->toISOString()])
            ->sum('price');

        $servicesAmountPercentageChange = $this->calculatePercentageChange($lastMonthServicesAmount, $currentMonthServicesAmount);
        $servicesAmountChangeDirection = $this->calculateChangeDirection($lastMonthServicesAmount, $currentMonthServicesAmount);

        $totalAdvisoryServicesAmount = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->sum('price');
        $doneAdvisoryServicesAmount = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('request_status', 5)->sum('price');
        $pendingAdvisoryServicesAmount = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [1, 2])->sum('price');
        $lateAdvisoryServicesAmount = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->whereIn('request_status', [3, 4])->sum('price');

        $lastMonthAdvisoryServicesAmount = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$lastMonth->startOfMonth()->toISOString(), $lastMonth->endOfMonth()->toISOString()])
            ->sum('price');
        $currentMonthAdvisoryServicesAmount = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$currentMonth->startOfMonth()->toISOString(), $currentMonth->endOfMonth()->toISOString()])
            ->sum('price');
        $advisoryServicesAmountPercentageChange = $this->calculatePercentageChange($lastMonthAdvisoryServicesAmount, $currentMonthAdvisoryServicesAmount);
        $advisoryServicesAmountChangeDirection = $this->calculateChangeDirection($lastMonthAdvisoryServicesAmount, $currentMonthAdvisoryServicesAmount);

        $doneAppointmentsAmount = Reservation::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('reservation_started', 1)->sum('price');
        $pendingAppointmentsAmount = Reservation::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('reservation_started', 0)->where('to', '<=', $today)->sum('price');
        $lateAppointmentsAmount = Reservation::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->where('reservation_started', 0)->where('to', '>', $today)->sum('price');

        $lastMonthAppointmentsAmount = Reservation::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$lastMonth->startOfMonth()->toISOString(), $lastMonth->endOfMonth()->toISOString()])
            ->sum('price');

        $currentMonthAppointmentsAmount = Reservation::where('reserved_from_lawyer_id', $account->id)
            ->where('transaction_complete', 1)
            ->whereBetween('created_at', [$currentMonth->startOfMonth()->toISOString(), $currentMonth->endOfMonth()->toISOString()])
            ->sum('price');

        $appointmentsAmountPercentageChange = $this->calculatePercentageChange($lastMonthAppointmentsAmount, $currentMonthAppointmentsAmount);
        $appointmentsAmountChangeDirection = $this->calculateChangeDirection($lastMonthAppointmentsAmount, $currentMonthAppointmentsAmount);

        $totalAppointmentsAmount = Reservation::where('reserved_from_lawyer_id', $account->id)->where('transaction_complete', 1)->sum('price');

        $responseObject = [
            "services" => [
                "total" => $totalServicesCount,
                "done" => $doneServicesCount,
                "pending" => $pendingServicesCount,
                "late" => $lateServicesCount,
                "percentageChange" => $servicesPercentageChange,
                "changeDirection" => $servicesChangeDirection,
                "amounts" => [
                    "total" => $totalServicesAmount,
                    "done" => $doneServicesAmount,
                    "pending" => $pendingServicesAmount,
                    "late" => $lateServicesAmount,
                    "percentageChange" => $servicesAmountPercentageChange,
                    "changeDirection" => $servicesAmountChangeDirection
                ]
            ],
            "advisoryServices" => [
                "total" => $totalAdvisoryServices,
                "done" => $doneAdvisoryServices,
                "pending" => $pendingAdvisoryServices,
                "late" => $lateAdvisoryServices,
                "percentageChange" => $advisoryServicesPercentageChange,
                "changeDirection" => $advisoryServicesChangeDirection,
                "amounts" => [
                    "total" => $totalAdvisoryServicesAmount,
                    "done" => $doneAdvisoryServicesAmount,
                    "pending" => $pendingAdvisoryServicesAmount,
                    "late" => $lateAdvisoryServicesAmount,
                    "percentageChange" => $advisoryServicesAmountPercentageChange,
                    "changeDirection" => $advisoryServicesAmountChangeDirection
                ]
            ],
            "appointments" => [
                "total" => $totalAppointments,
                "done" => $doneAppointments,
                "pending" => $pendingAppointments,
                "percentageChange" => $appointmentsPercentageChange,
                "changeDirection" => $appointmentsChangeDirection,
                "amounts" => [
                    "total" => $totalAppointmentsAmount,
                    "done" => $doneAppointmentsAmount,
                    "pending" => $pendingAppointmentsAmount,
                    "late" => $lateAppointmentsAmount,
                    "percentageChange" => $appointmentsAmountPercentageChange,
                    "changeDirection" => $appointmentsAmountChangeDirection
                ]
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

    private function calculatePercentageChange($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0;
        }
        $percentageChange = (($newValue - $oldValue) / $oldValue) * 100;
        return abs($percentageChange);
    }

    private function calculateChangeDirection($oldValue, $newValue)
    {
        if ($newValue > $oldValue) {
            return 'up';
        } elseif ($newValue < $oldValue) {
            return 'down';
        } else {
            return 'same';
        }
    }
}
