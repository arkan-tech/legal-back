<?php

namespace App\Http\Tasks\Lawyer\NewReservations;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\Reservations\ReservationType;
use App\Models\Reservations\ReservationTypeImportance;

class DeleteReservationsPriceTask extends BaseTask
{
    public function run(Request $request, $id)
    {
        $lawyer = Account::find(auth()->user()->id);

        $reservations = ReservationType::with([
            'typesImportance' => function ($query) use ($lawyer) {
                $query->where('account_id', $lawyer->id);
            },
        ])->findOrFail($id);
        if (count($reservations->typesImportance) == 0) {
            return $this->sendResponse(false, 'There are no Reservations to delete', null, 400);
        }
        foreach ($reservations->typesImportance as $reservation) {
            $reservation->delete();
        }

        return $this->sendResponse(true, 'Reservation has been deleted', null, 200);

    }
}
