<?php
namespace App\Http\Tasks\Lawyer\WorkingHours;

use Carbon\Carbon;
use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\WorkingHours\WorkingHours;
use App\Http\Requests\AddWorkingHoursRequest;

class AddWorkingHoursTask extends BaseTask
{

    public function run(Request $request)
    {
        \Log::error('test');
        $lawyer = Account::find(auth()->user()->id);
        $validated = $request->validate([
            'times' => 'required|array',
            'times.*.service' => 'required|in:1,2,3',
            'times.*.dayOfWeek' => 'required|in:1,2,3,4,5,6,7',
            'times.*.from' => 'required',
            'times.*.to' => 'required',
            'times.*.minsBetween' => 'required|integer',
        ]);

        $times = $validated['times'];

        foreach ($times as $newTime) {
            foreach ($times as $existingTime) {
                if ($newTime !== $existingTime && $newTime['dayOfWeek'] == $existingTime['dayOfWeek']) {
                    if ($this->isTimeOverlap($newTime['from'], $newTime['to'], $existingTime['from'], $existingTime['to'])) {
                        return $this->sendResponse(false, 'يوجد مواعيد متعارضة', null, 409);
                    }
                }
            }
        }

        WorkingHours::where('account_details_id', $lawyer->lawyerDetails()->first()->id)->delete();
        $newTimes = [];
        foreach ($times as $time) {
            $newTimes[] = WorkingHours::create([
                'account_details_id' => $lawyer->lawyerDetails()->first()->id,
                'service' => $time['service'],
                'dayOfWeek' => $time['dayOfWeek'],
                'from' => $time['from'],
                'to' => $time['to'],
                'minsBetween' => $time['minsBetween'],
                'isRepeatable' => false,
                'noOfRepeats' => 0,
            ]);
        }

        return $this->sendResponse(true, 'تمت تعديل مواعيد العمل', null, 200);

    }

    protected function isTimeOverlap($newFrom, $newTo, $existingFrom, $existingTo)
    {
        $newFromTime = Carbon::parse($newFrom);
        $newToTime = Carbon::parse($newTo);
        $existingFromTime = Carbon::parse($existingFrom);
        $existingToTime = Carbon::parse($existingTo);

        return $newFromTime->lt($existingToTime) && $newToTime->gt($existingFromTime);
    }
}
