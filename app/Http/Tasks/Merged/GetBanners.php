<?php

namespace App\Http\Tasks\Merged;

use App\Http\Resources\BannersResource;
use Carbon\Carbon;
use App\Models\Banners;
use App\Models\Activity;
use App\Http\Tasks\BaseTask;
use App\Models\ContactYmtaz;
use Illuminate\Http\Request;
use App\Http\Resources\ActivityResource;
use App\Http\Requests\API\Merged\CreateContactUsRequest;

class GetBanners extends BaseTask
{
    public function run()
    {
        // Get the current date and time
        $now = Carbon::now();

        // Fetch banners that are not expired or have null expiration date
        $banners = Banners::where(function ($query) use ($now) {
            $query->where('expires_at', '>', $now)
                ->orWhereNull('expires_at');
        })->get();
        $banners = BannersResource::collection($banners);
        // Return the filtered banners in the response
        return $this->sendResponse(true, "Fetch Banners", compact('banners'), 200);
    }
}
