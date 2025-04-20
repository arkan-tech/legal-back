<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Account;
use App\Models\YmtazSlots;
use Illuminate\Http\Request;
use App\Models\AdvisoryCommittee;
use App\Models\YmtazSlotsAssignee;

class YmtazSlotsController extends Controller
{
    public function index()
    {
        $slots = YmtazSlots::with('assignees.assignee')->get();
        $lawyers = Account::where('account_type', 'lawyer')->whereHas('lawyerDetails', function ($query) {
            $query->where('is_advisor', 1);
        })->with('lawyerDetails.lawyerAdvisories')->get();
        return Inertia::render('Settings/YmtazSlots/index', get_defined_vars());
    }

    public function updateAssignees(Request $request, $slotId)
    {
        $assigneeIds = $request->input('assignee_ids');
        $leaderId = $request->input('leader_id');

        $slot = YmtazSlots::find($slotId);

        if ($leaderId !== null) {
            $slot->leader_id = $leaderId;
            $slot->save();
        }

        if ($assigneeIds !== null) {
            YmtazSlotsAssignee::where('slot_id', $slotId)->delete();
            foreach ($assigneeIds as $assigneeId) {
                YmtazSlotsAssignee::create([
                    'slot_id' => $slotId,
                    'assignee_id' => $assigneeId,
                ]);
            }
        }

        $slot = YmtazSlots::with('assignees.assignee', 'leader')->find($slotId);

        return response()->json(['success' => true, 'slot' => $slot]);
    }
}
