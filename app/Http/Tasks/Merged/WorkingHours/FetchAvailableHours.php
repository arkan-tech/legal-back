<?php

namespace App\Http\Tasks\Merged\WorkingHours;

use Carbon\Carbon;
use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\API\Splash\Splash;
use App\Models\Client\ClientRequest;
use App\Models\ServicesReservations;
use App\Models\Reservations\Reservation;
use App\Models\WorkingHours\WorkingHours;
use App\Models\AdvisoryServicesReservations;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Models\LawyerAdditionalInfo;

class FetchAvailableHours extends BaseTask
{
    public function run(Request $request, $productId)
    {
        if (!in_array($productId, [1, 2, 3])) {
            return $this->sendResponse(false, 'Invalid Product Id', null, 400);
        }

        $validated = $request->validate([
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after_or_equal:from_date',
            'required_time' => 'required|integer',
        ]);

        $fromDate = Carbon::parse($validated['from_date']);
        $toDate = Carbon::parse($validated['to_date']);
        $period = $validated['required_time'];
        $days = [];
        $lawyer = is_null($request->lawyer_id) ? null : LawyerAdditionalInfo::where('account_id', $request->lawyer_id)->first();
        $lawyer_id = is_null($lawyer) ? null : $lawyer->id;

        $currentDateTime = Carbon::now();
        for ($date = $fromDate; $date->lte($toDate); $date->addDay()) {
            $dayOfWeek = $this->mapDayOfWeek($date->dayOfWeek); // Map to the correct dayOfWeek
            $lawyerTimes = WorkingHours::where('dayOfWeek', $dayOfWeek)->where('service', $productId)->where('account_details_id', $lawyer_id)->get();
            if ($productId == 1) {
                $reservations = Reservation::where('day', $date->toDateString())->where('reserved_from_lawyer_id', $lawyer_id)->where('transaction_complete', 1)->get();
            }
            if ($productId == 2) {
                $reservations = ServicesReservations::where('transaction_complete', 1)->where('day', $date->toDateString())->where('reserved_from_lawyer_id', $lawyer_id)->get();

            }
            if ($productId == 3) {
                $reservations = AdvisoryServicesReservations::where('transaction_complete', 1)->where('day', $date->toDateString())->where('reserved_from_lawyer_id', $lawyer_id)->get();

            }
            foreach ($lawyerTimes as $time) {
                $availableTimes = $this->getAvailablePeriods($time, $date->toDateString(), $period, $reservations, $currentDateTime);

                if (!empty($availableTimes)) {
                    $days[] = [
                        'date' => $date->toDateString(),
                        "workingHours" => $time->from . " - " . $time->to,
                        'availableTimes' => $availableTimes,
                    ];
                }
            }
        }

        return response()->json(['days' => $days], 200);
    }

    // Helper method to calculate available periods
    protected function getAvailablePeriods($time, $date, $period, $reservations, $currentDateTime)
    {
        $availableTimes = [];
        $start = Carbon::parse($date . ' ' . $time->from);
        $end = Carbon::parse($date . ' ' . $time->to);
        $minsBetween = $time->minsBetween;

        $isToday = Carbon::parse($date)->isToday();

        while ($start->copy()->addMinutes($period)->lte($end)) {
            $endTime = $start->copy()->addMinutes($period);
            $isReserved = $this->isTimeSlotReserved($date, $start, $endTime, $reservations);
            if ($isToday && $start->lte($currentDateTime->copy()->addHours(2))) {
                $start = $start->addMinutes($minsBetween); // Move to the next slot
                continue;
            }
            if (!$isReserved) {
                $availableTimes[] = [
                    'from' => $start->format('H:i'),
                    'to' => $endTime->format('H:i'),
                ];

                // Move to the next available slot after the break
                $start = $endTime->addMinutes($minsBetween);
            } else {
                // If the current slot is reserved, move to the end of the reservation plus the break period
                $start = $this->getNextAvailableStartTime($date, $start, $reservations, $minsBetween);
            }
        }

        return $availableTimes;
    }

    protected function getNextAvailableStartTime($date, $currentStart, $reservations, $minsBetween)
    {
        $minsBetween = max($minsBetween, 1); // Ensure at least 1 minute between slots
        foreach ($reservations as $reservation) {
            $resFrom = Carbon::parse($date . ' ' . Carbon::parse($reservation->from)->format('H:i:s'));
            $resTo = Carbon::parse($date . ' ' . Carbon::parse($reservation->to)->format('H:i:s'));
            if ($currentStart->between($resFrom, $resTo) || $currentStart->lt($resTo)) {
                $nextTime = $resTo->copy()->addMinutes($minsBetween);
                if ($nextTime->eq($currentStart)) {
                    // Ensure we move forward in time
                    $nextTime = $nextTime->addMinute();
                }
                return $nextTime;
            }
        }

        return $currentStart;
    }
    protected function isTimeSlotReserved($date, $start, $end, $reservations)
    {
        foreach ($reservations as $reservation) {
            $resFrom = Carbon::parse($date . ' ' . Carbon::parse($reservation->from)->format('H:i:s'));
            $resTo = Carbon::parse($date . ' ' . Carbon::parse($reservation->to)->format('H:i:s'));

            $isBetween = $start->between($resFrom, $resTo) || $end->between($resFrom, $resTo) || $resFrom->between($start, $end) || $resTo->between($start, $end);

            if ($isBetween) {
                return true;
            }
        }

        return false;
    }

    protected function mapDayOfWeek($dayOfWeek)
    {
        $map = [
            0 => 1, // Sunday in Carbon is 0, in DB it's 1
            1 => 2, // Monday in Carbon is 1, in DB it's 2
            2 => 3, // Tuesday in Carbon is 2, in DB it's 3
            3 => 4, // Wednesday in Carbon is 3, in DB it's 4
            4 => 5, // Thursday in Carbon is 4, in DB it's 5
            5 => 6, // Friday in Carbon is 5, in DB it's 6
            6 => 7, // Saturday in Carbon is 6, in DB it's 7
        ];

        return $map[$dayOfWeek];
    }
}
