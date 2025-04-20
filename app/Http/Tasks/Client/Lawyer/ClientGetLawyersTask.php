<?php

namespace App\Http\Tasks\Client\Lawyer;

use Carbon\Carbon;
use App\Http\Tasks\BaseTask;
use App\Models\Account;
use App\Models\ServicesReservations;
use App\Http\Resources\AccountResourcePublic;
use App\Models\AdvisoryServicesReservations;
use App\Models\Client\ClientRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservations\Reservation;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\Client\ClientLawyersDataResource;
use App\Http\Resources\API\Client\LawyerClientsDataResource;
use App\Http\Resources\API\Lawyer\LawyerServicesPriceResource;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;

class ClientGetLawyersTask extends BaseTask
{

    public function run()
    {
        $user = auth()->user();

        $lawyerRequests = ServicesReservations::where('account_id', $user->id)
            ->whereNotNull('reserved_from_lawyer_id')
            ->distinct('reserved_from_lawyer_id')
            ->pluck('reserved_from_lawyer_id');
        $advisoryServiceLawyers = AdvisoryServicesReservations::where('account_id', $user->id)
            ->whereNotNull('reserved_from_lawyer_id')
            ->distinct('reserved_from_lawyer_id')
            ->pluck('reserved_from_lawyer_id');
       
        $reservationLawyers = Reservation::where(
            'account_id',
            $user->id
        )
            ->whereNotNull('reserved_from_lawyer_id')
            ->distinct('reserved_from_lawyer_id')
            ->pluck('reserved_from_lawyer_id');


        $allLawyerIds = $lawyerRequests->merge($reservationLawyers)
            ->merge($advisoryServiceLawyers)
            ->unique();
        $lawyers = Account::whereIn('id', $allLawyerIds)->get();

        $clients = AccountResourcePublic::collection($lawyers);
        return $this->sendResponse(true, 'مقدمي خدمة العميل', compact('clients'), 200);
    }
}
