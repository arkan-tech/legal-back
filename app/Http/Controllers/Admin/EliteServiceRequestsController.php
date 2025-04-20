<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EliteServiceRequest;
use App\Models\EliteServicePricingCommittee;
use App\Models\Account;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Schema;

class EliteServiceRequestsController extends Controller
{
    public function index()
    {
        $requests = EliteServiceRequest::with([
            'requester:id,name,deleted_at',
            'eliteServiceCategory:id,name',
            'files',
            'offers',
            'pricer:id,name'
        ])->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'requester' => [
                        'name' => $request->requester ? $request->requester->name : 'غير معروف',
                        'deleted_at' => $request->requester ? $request->requester->deleted_at : null
                    ],
                    'eliteServiceCategory' => [
                        'name' => $request->eliteServiceCategory ? $request->eliteServiceCategory->name : 'غير معروف'
                    ],
                    'description' => $request->description,
                    'transaction_complete' => $request->transaction_complete,
                    'status' => $request->status ?? 'pending',
                    'pricer' => $request->pricer ? [
                        'id' => $request->pricer->id,
                        'name' => $request->pricer->name
                    ] : null,
                    'created_at' => $request->created_at
                ];
            });

        return Inertia::render('EliteServiceRequests/index', [
            'requests' => $requests
        ]);
    }

    public function show($id)
    {
        // Get the basic request data first
        $request = EliteServiceRequest::with([
            'requester',
            'eliteServiceCategory',
            'files',
            'pricer'
        ])->findOrFail($id);

        // Then load offers separately with explicit eager loading for each relationship
        if ($request->offers) {
            $request->load([
                'offers' => function ($query) {
                    $query->with([
                        'advisoryServiceSub',
                        'serviceSub',
                        'reservationType'
                    ]);
                }
            ]);

            // If advisory service sub exists, load its relationships
            if ($request->offers->advisoryServiceSub) {
                $request->offers->advisoryServiceSub->load('generalCategory');
                if ($request->offers->advisoryServiceSub->generalCategory) {
                    $request->offers->advisoryServiceSub->generalCategory->load('paymentCategoryType');
                }
            }

            // If service sub exists, load its category
            if ($request->offers->serviceSub) {
                $request->offers->serviceSub->load('category');
            }

            // No need to load category for reservationType as it doesn't exist
        }

        // Debug output to Laravel logs
        \Log::debug('Elite Service Request Relationships:', [
            'offers' => $request->offers,
            'advisoryServiceSub' => $request->offers ? $request->offers->advisoryServiceSub : null,
            'serviceSub' => $request->offers ? $request->offers->serviceSub : null,
            'reservationType' => $request->offers ? $request->offers->reservationType : null,
        ]);

        $pricingCommittee = EliteServicePricingCommittee::with('account')
            ->where('is_active', true)
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->account->id,
                    'name' => $member->account->name
                ];
            });

        return Inertia::render('EliteServiceRequests/Show/index', [
            'request' => $request,
            'pricingCommittee' => $pricingCommittee
        ]);
    }

    public function assignPricer(Request $request, $id)
    {
        $validated = $request->validate([
            'pricer_account_id' => 'required|exists:accounts,id'
        ]);

        $serviceRequest = EliteServiceRequest::findOrFail($id);
        $serviceRequest->update([
            'pricer_account_id' => $validated['pricer_account_id']
        ]);

        return back()->with('success', 'تم تعيين عضو لجنة التسعير بنجاح');
    }
}
