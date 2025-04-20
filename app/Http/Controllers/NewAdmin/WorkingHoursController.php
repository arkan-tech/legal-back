<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkingHours\WorkingHours;

class WorkingHoursController extends Controller
{
    public function index()
    {
        $workingHours = WorkingHours::whereNull('account_details_id')->get();
        $workingSchedule = new WorkingSchedule;
        foreach ($workingHours as $workingHour) {
            $workingSchedule->addTimeSlot($workingHour->service, $workingHour->dayOfWeek, $workingHour->from, $workingHour->to);
        }
        $workingSchedule = $workingSchedule->getSchedule();
        return Inertia::render('WorkingHours/index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $workingSchedule = $request->workingSchedule;

        $workingHours = WorkingHours::where('service', $request->service)->whereNull('account_details_id')->delete();
        foreach ($workingSchedule as $workingDay) {
            foreach ($workingDay["timeSlots"] as $timeSlot) {
                WorkingHours::create([
                    'dayOfWeek' => $workingDay['dayOfWeek'],
                    'from' => $timeSlot['from'],
                    'to' => $timeSlot['to'],
                    'service' => $request->service,
                    "minsBetween" => 15,
                    "isRepeatable" => 0
                ]);
            }
        }

        return response()->json([
            'status' => true
        ]);
    }
}

class WorkingSchedule
{
    protected $services = [];

    public function addTimeSlot($service, $dayOfWeek, $from, $to)
    {
        if (!isset($this->services[$service])) {
            $this->services[$service] = [
                'service' => $service,
                'days' => [],
            ];
        }

        if (!isset($this->services[$service]['days'][$dayOfWeek])) {
            $this->services[$service]['days'][$dayOfWeek] = [
                'dayOfWeek' => $dayOfWeek,
                'timeSlots' => [],
            ];
        }

        $this->services[$service]['days'][$dayOfWeek]['timeSlots'][] = ['from' => $from, 'to' => $to];
    }


    public function getSchedule()
    {
        $schedule = [];

        foreach ($this->services as $service) {
            $serviceObj = [
                'service' => $service['service'],
                'days' => array_values($service['days']), // Reindexing days array
            ];

            $schedule[] = $serviceObj;
        }

        return $schedule;
    }
}
