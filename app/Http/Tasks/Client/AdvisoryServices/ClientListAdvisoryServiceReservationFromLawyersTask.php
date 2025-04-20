<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServicesReservations;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Requests\API\Client\AdvisoryService\ClientCreateAdvisoryServiceReservationRequest;

class ClientListAdvisoryServiceReservationFromLawyersTask extends BaseTask
{

    public function run()
    {
        $client = $this->authAccount();

        $reservations = AdvisoryServicesReservations::where('transaction_complete', 1)->whereNotNull('reserved_from_lawyer_id')->where('account_id', '=', $client->id)->with('subCategoryPrice.subCategory.generalCategory.paymentCategoryType')->orderBy('created_at', 'desc')->get();
        $reservations = AdvisoryServicesReservationResource::collection($reservations);
        return $this->sendResponse(true, 'قائمة طلبات الاستشارات من مقدمي الخدمة', compact('reservations'), 200);

    }
}
