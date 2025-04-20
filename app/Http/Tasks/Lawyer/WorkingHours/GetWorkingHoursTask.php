<?php
namespace App\Http\Tasks\Lawyer\WorkingHours;

use App\Models\Account;
use Carbon\Carbon;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\WorkingHours\WorkingHours;
use App\Http\Requests\AddWorkingHoursRequest;

class GetWorkingHoursTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = Account::find(auth()->user()->id);
        $workingHours = WorkingHours::where('account_details_id', $lawyer->lawyerDetails()->first()->id)->get();
        $workingSchedule = new WorkingSchedule;
        foreach ($workingHours as $workingHour) {
            $workingSchedule->addTimeSlot($workingHour->service, $workingHour->dayOfWeek, $workingHour->from, $workingHour->to);
        }
        $workingSchedule = $workingSchedule->getSchedule();
        return $this->sendResponse(true, "Working Hours", compact('workingSchedule'), 200);
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
