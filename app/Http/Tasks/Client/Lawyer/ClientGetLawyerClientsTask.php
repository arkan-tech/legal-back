<?php

namespace App\Http\Tasks\Client\Lawyer;

use Carbon\Carbon;
use App\Models\Account;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Client\ClientRequest;
use App\Models\ServicesReservations;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservations\Reservation;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\AdvisoryServicesReservations;
use App\Http\Resources\AccountResourcePublic;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Client\LawyerClientsDataResource;
use App\Http\Resources\API\Lawyer\LawyerServicesPriceResource;

class ClientGetLawyerClientsTask extends BaseTask
{

    public function run()
    {
        $user = $this->authAccount();
        $lawyerRequests = ServicesReservations::where('reserved_from_lawyer_id', $user->id)
            ->whereNotNull('account_id')
            ->distinct('account_id')
            ->pluck('account_id');
        $advisoryServiceLawyers = AdvisoryServicesReservations::where('reserved_from_lawyer_id', $user->id)
            ->whereNotNull('account_id')
            ->distinct('account_id')
            ->pluck('account_id');

        $reservationLawyers = Reservation::where(
            'reserved_from_lawyer_id',
            $user->id
        )
            ->whereNotNull('account_id')
            ->distinct('account_id')
            ->pluck('account_id');

        $allLawyerIds = $lawyerRequests->merge($reservationLawyers)
            ->merge($advisoryServiceLawyers)
            ->unique();
        $lawyers = Account::whereIn('id', $allLawyerIds)->get();
        $clients = AccountResourcePublic::collection($lawyers);
        return $this->sendResponse(true, 'عملاء مقدم الخدمة', compact(['clients']), 200);
    }
}
