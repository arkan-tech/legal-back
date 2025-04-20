<?php

namespace App\Http\Tasks\Merged\Packages;

use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Models\Activity;
use App\Http\Tasks\BaseTask;
use App\Models\ContactYmtaz;
use Illuminate\Http\Request;
use App\Http\Resources\ActivityResource;
use App\Http\Requests\API\Merged\CreateContactUsRequest;

class GetPackagesTask extends BaseTask
{
    public function run(Request $request)
    {
        $user = $this->authAccount();
        $packages = Package::with([
            'advisoryServices.advisory_services_prices' => function ($query) {
                $query->where('is_ymtaz', 1);
            },
        ])->with([
                    'reservations.typesImportance' => function ($query) {
                        $query->where('isYmtaz', 1)->with(['reservationType', 'reservationImportance']);
                    }
                ])
            ->where(function ($query) use ($user) {
                $query->where('package_type', $user->account_type == "client" ? 1 : 2);
            })
            ->where(function ($query) use ($user) {
                $query->where('targetedType', 0)
                    ->orWhere('targetedType', $user->type);
            })
            ->get();

        if ($user->account_type === 'lawyer') {
            $packages = $packages->filter(function ($package) use ($user) {
                return $package->hasSectionsForLawyer($user->id, $package->sections->pluck('section_id')->toArray());
            });
        }

        $packages = PackageResource::collection($packages);
        return $this->sendResponse(true, "Fetch packages", compact('packages'), 200);
    }
}
