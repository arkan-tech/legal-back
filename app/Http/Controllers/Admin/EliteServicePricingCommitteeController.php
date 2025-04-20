<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EliteServicePricingCommittee;
use App\Models\Account;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EliteServicePricingCommitteeController extends Controller
{
    public function index()
    {
        $committee = EliteServicePricingCommittee::with('account')
            ->get()
            ->map(function ($member) {
                $stats = $member->getStatistics();
                return [
                    'id' => $member->id,
                    'account' => $member->account,
                    'is_active' => $member->is_active,
                    'statistics' => $stats
                ];
            });

        $lawyers = Account::where('account_type', 'lawyer')->get();

        return Inertia::render('Settings/EliteServicePricingCommittee/index', [
            'committee' => $committee,
            'lawyers' => $lawyers
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id'
        ]);

        EliteServicePricingCommittee::create([
            'account_id' => $validated['account_id'],
            'is_active' => true
        ]);

        return back()->with('success', 'تم إضافة العضو بنجاح');
    }

    public function toggleActive(Request $request, $id)
    {
        $member = EliteServicePricingCommittee::where('account_id', $id)->firstOrFail();
        $member->update([
            'is_active' => !$member->is_active
        ]);

        return back()->with('success', 'تم تحديث حالة العضو بنجاح');
    }

    public function destroy($id)
    {
        $member = EliteServicePricingCommittee::where('account_id', $id)->firstOrFail();
        $member->delete();

        return back()->with('success', 'تم حذف العضو بنجاح');
    }
}
