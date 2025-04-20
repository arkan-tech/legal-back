<?php

namespace App\Http\Tasks\Merged\Packages;

use App\Models\Packages\PackageSubscription;
use App\Http\Tasks\BaseTask;
use App\Http\Resources\PackageSubscriptionResource;
use Carbon\Carbon;

class GetSubscriptionDetailsTask extends BaseTask
{
    public function run($request)
    {
        $user = $this->authAccount();
        $currentDate = Carbon::now();
        $subscription = PackageSubscription::with('package.permissions')
            ->where('account_id', $user->id)
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->latest()
            ->first();

        if (!$subscription) {
            return ['status' => false, 'message' => 'Subscription not found', 'data' => [], 'code' => 404];
        }

        return [
            'status' => true,
            'message' => 'Subscription details fetched successfully',
            'data' => new PackageSubscriptionResource($subscription),
            'code' => 200
        ];
    }
}
