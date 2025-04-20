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
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Resources\API\Lawyer\Reservations\LawyerReservationsResource;
use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Requests\API\Lawyer\Reservations\LawyerCreateReservationRequest;

class LawyerCreateReservationPriceTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = Account::find(auth()->user()->id);

        $request->validate([
            "reservation_type_id" => "required",
            "reservationsTypesImportances" => "required"
        ], ["*" => "الحقل مطلوب"]);

        $reservationType = ReservationType::findOrFail($request->reservation_type_id);
        $previousReservations = ReservationTypeImportance::where("isYmtaz", 0)->where("account_id", $lawyer->id)->where("reservation_types_id", $reservationType->id);
        $previousReservations->delete();

        foreach ($request->reservationsTypesImportances as $reservation) {
            if ($reservation["price"] < $reservationType->minPrice) {
                return $this->sendResponse(false, "سعر المستوى يجب ان يكون اعلى من الحد الأدنى", null, 400);
            } else if ($reservation["price"] > $reservationType->maxPrice) {
                return $this->sendResponse(false, "سعر المستوى يجب ان يكون اقل من الحد الأقصى", null, 400);

            } else {
                ReservationTypeImportance::create([
                    "reservation_types_id" => $reservationType->id,
                    "reservation_importance_id" => $reservation["importance_id"],
                    "price" => $reservation["price"],
                    'isHidden' => $reservation['isHidden'],
                    'isYmtaz' => 0,
                    "account_id" => $lawyer->id,
                ]);
            }
        }
        return $this->sendResponse(true, "Created Reservations Prices", null, 200);
    }
}
