<?php

namespace App\Http\Resources;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;
use App\Http\Resources\API\Reservations\ReservationResource;
use App\Http\Resources\API\Reservations\ReservationTypeResource;
use App\Http\Resources\API\Services\ServicesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PackageResourceShort extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'durationType' => $this->duration_type,
            'duration' => $this->duration,
        ];
    }

    private function mapWithBookings($collection)
    {
        return $collection->map(function ($item) {
            $itemArray = $item->toArray(request());
            $itemArray['number_of_bookings'] = $item->pivot->number_of_bookings;
            return $itemArray;
        });
    }

    /**
     * Check if the given user is subscribed to the package.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    private function isUserSubscribed($user): bool
    {
        $currentDate = Carbon::now();
        $latestSubscription = $user->subscriptions()
            ->where('start_date', '<=', $currentDate)
            ->where(function ($query) use ($currentDate) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $currentDate);
            })
            ->orderBy('start_date', 'desc') // Most recent active subscription
            ->first();
        // Check if the latest subscription is for this specific package
        return $latestSubscription && $latestSubscription->id === $this->id;
    }
}
