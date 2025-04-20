<?php

namespace App\Http\Tasks\Lawyer\NewReservations;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Reservations\ReservationType;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Models\ClientReservations\ClientReservations;
use App\Models\LawyerReservations\LawyerReservations;
use App\Models\Reservations\ReservationTypeImportance;
use App\Http\Resources\API\Reservations\ReservationTypeResource;
use App\Http\Resources\API\Reservations\ReservationTypeResourceCreation;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Lawyer\Reservations\LawyerReservationsResource;
use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\LawyerCreateReservationRequest;

class LawyerGetReservationTypesTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = Account::find(auth()->user()->id);
        $reservationTypes = ReservationType::with(
            [
                'typesImportance' => function ($query) {
                    $query->where('isYmtaz', 1);
                }
            ]
        )->get();
        $reservationTypes = $reservationTypes->each(function ($reservationType) use ($lawyer) {
            $lawyerPrices = ReservationTypeImportance::where(['account_id' => $lawyer->id, 'reservation_types_id' => $reservationType->id])->with('reservationImportance')->get();
            $isActivated = $lawyerPrices->isNotEmpty();
            $reservationType['is_activated'] = $isActivated;
            $reservationType['isHidden'] = count($lawyerPrices) > 0 ? $lawyerPrices->some(function ($ls) {
                return $ls->isHidden == true;
            }) : null;
            if ($isActivated) {
                $reservationType['lawyerPrices'] = $lawyerPrices->map(function ($price) {
                    return [
                        'id' => $price->id,
                        'price' => $price->price,
                        'isHidden' => $price->isHidden,
                        'level' => [
                            "id" => $price->reservationImportance->id,
                            "name" => $price->reservationImportance->name,

                        ]
                    ];
                });
            } else {
                $reservationType['lawyerPrices'] = [];
            }
        });
        $reservationTypes = ReservationTypeResourceCreation::collection($reservationTypes);

        return $this->sendResponse(true, 'Reservations Types', compact('reservationTypes'), 200);
    }
}
