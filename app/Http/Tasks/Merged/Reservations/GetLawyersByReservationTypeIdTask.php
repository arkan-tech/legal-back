<?php

namespace App\Http\Tasks\Merged\Reservations;

use App\Http\Tasks\BaseTask;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountResourcePublic;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Reservations\ReservationTypeImportance;
use App\Http\Resources\API\Reservations\ReservationImportanceResource;
use App\Http\Resources\API\Reservations\ReservationTypeImportanceResource;

class GetLawyersByReservationTypeIdTask extends BaseTask
{
    public function run($request, $reservation_type_id)
    {
        $importance_id = $request->query('importance_id');
        $lawyers = ReservationTypeImportance::where('reservation_types_id', $reservation_type_id)
            ->whereNotNull('account_id')
            ->where('isHidden', 0)
            ->when($importance_id, function ($query, $importance_id) {
                return $query->where('reservation_importance_id', $importance_id);
            })
            ->with([
                'lawyer.lawyerDetails' => function ($query) {
                    $query->notAdvisor();
                },
                'reservationType',
                'reservationImportance'
            ])
            ->get();

        $lawyers = ReservationTypeImportanceShortResource::collection($lawyers);
        return $this->sendResponse(true, 'Lawyers fetched successfully', $lawyers, 200);
    }
}

class ReservationTypeImportanceShortResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'reservation_type' => $this->reservationType,
            'reservation_importance' => new ReservationImportanceResource($this->reservationImportance),
            'isYmtaz' => $this->isYmtaz,
            'lawyer' => new AccountResourcePublic($this->lawyer),
        ];
    }
}
