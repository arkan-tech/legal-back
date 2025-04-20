<?php

namespace App\Http\Tasks\Merged\Reservations;

use App\Http\Tasks\BaseTask;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\API\Splash\Splash;
use App\Models\Reservations\ReservationType;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\API\Reservations\ReservationTypeResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;

class GetReservationTypesTaskForLawyer extends BaseTask
{

    public function run(Request $request, $lawyer_id)
    {
        $lawyer = Account::findOrFail($lawyer_id);
        $reservations_types = ReservationType::whereHas('typesImportance', function ($query) use ($lawyer_id) {
            $query->where('account_id', $lawyer_id)->where('isHidden', 0);
        })->with(
                [
                    'typesImportance' => function ($query) use ($lawyer_id) {
                        $query->where('account_id', $lawyer_id)->where('isHidden', 0);
                    }
                ]
            )->get();
        $reservations_types = ReservationTypeResource::collection($reservations_types);
        // Return response using a resource to transform the data if necessary
        return $this->sendResponse(true, 'Reservation Types', compact('reservations_types'), 200);
    }
}
