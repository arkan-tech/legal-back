<?php

namespace App\Http\Tasks\Merged\Reservations;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Models\Reservations\ReservationType;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\API\Reservations\ReservationTypeResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;

class GetReservationTypesForPricingTask extends BaseTask
{

    public function run()
    {
        $lawyer = Account::find(auth()->user()->id);
        $reservationTypes = ReservationType::where('isHidden', 0)->with([
            'typesImportance' => function ($query) {
                $query->where('isYmtaz', 1)->where('isHidden', 0);
            }
        ])->get();

        $reservationTypes = $reservationTypes->map(function ($type) use ($lawyer) {

            $type['ymtazPrices'] = $type->typesImportance->map(function ($importance) {
                return [
                    'id' => $importance->id,
                    'price' => $importance->price,
                    'isHidden' => $importance->isHidden,
                    'level' => [
                        'id' => $importance->reservation_importance_id,
                        'name' => $importance->reservationImportance->name,
                    ],
                ];
            });
            unset($type->deleted_at);
            unset($type->created_at);
            unset($type->updated_at);
            $typeLawyerPrices = $type->typesImportance()->where('account_id', $lawyer->id)->get();
            $type['is_activated'] = $typeLawyerPrices->isNotEmpty();
            $type['isHidden'] = count($typeLawyerPrices) > 0 ? $typeLawyerPrices->some(function ($tls) {
                return $tls->isHidden == true;
            }) : null;
            $type['lawyerPrices'] = $typeLawyerPrices->map(function ($importance) {
                return [
                    'id' => $importance->id,
                    'price' => $importance->price,
                    'isHidden' => $importance->isHidden,
                    'level' => [
                        'id' => $importance->reservation_importance_id,
                        'name' => $importance->reservationImportance->name,
                    ],
                ];
            });
            $type->makeHidden('typesImportance');

            return $type;
        });

        return $this->sendResponse(true, 'Reservation Types', $reservationTypes, 200);
    }
}
