<?php

namespace App\Http\Tasks\Reservations;

use App\Http\Resources\API\Reservations\ReservationTypeImportanceResource;
use App\Http\Tasks\BaseTask;
use App\Models\Reservations\ReservationTypeImportance;
use Illuminate\Http\Request;
use App\Models\AppointmentsSubPrices;
use App\Http\Resources\AppointmentPricesResource;

class GetLawyersByMainCategoryIdTask extends BaseTask
{
    public function run(Request $request, $rti_id)
    {
        $lawyersPrices = ReservationTypeImportance::where('resevation_types_id', $rti_id)
            ->where('reservation_importance_id', $request->query('importance_id'))
            ->whereNotNull('account_id')
            ->whereHas('lawyer', function ($query) use ($request) {
                if ($request->has('region_id')) {
                    $query->where('region_id', $request->query('region_id'));
                }
                if ($request->has('city_id')) {
                    $query->where('city_id', $request->query('city_id'));
                }
            })
            ->get();
        $lawyersPrices = ReservationTypeImportanceResource::collection($lawyersPrices);
        return [
            'status' => true,
            'message' => 'Lawyers fetched successfully.',
            'data' => compact('lawyersPrices'),
            'code' => 200
        ];
    }
}
