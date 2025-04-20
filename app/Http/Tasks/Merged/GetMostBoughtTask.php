<?php

namespace App\Http\Tasks\Merged;

use App\Http\Resources\AdvisoryServicesSubCategoriesResource;
use App\Http\Resources\ServicesReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Models\Service\Service;
use App\Models\ServicesReservations;
use Illuminate\Support\Facades\DB;
use App\Models\Client\ClientRequest;
use App\Models\Service\ServicesType;
use App\Models\Reservations\Reservation;
use App\Models\AdvisoryServicesReservations;
use App\Models\Reservations\ReservationType;
use App\Http\Resources\API\Services\ServicesResource;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\Reservations\ReservationTypeImportance;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\Reservations\ReservationTypeResource;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;


class GetMostBoughtTask extends BaseTask
{
    public function run()
    {
        $AdvisoryCounts = AdvisoryServicesReservations::leftJoin('advisory_services_sub_categories_prices as asscp', 'advisory_services_reservations.sub_category_price_id', '=', 'asscp.id')
            ->where('advisory_services_reservations.transaction_complete', 1)
            ->select('asscp.sub_category_id', DB::raw('COUNT(advisory_services_reservations.id) AS occurance'))
            ->groupBy('asscp.sub_category_id')
            ->orderBy('occurance', 'DESC')
            ->limit(3)
            ->pluck('occurance', 'asscp.sub_category_id');
        $topAdvisoryServices = $AdvisoryCounts->keys();
        $advisoryServices = AdvisoryServicesSubCategoriesResource::collection(
            AdvisoryServicesSubCategory::whereIn('id', $topAdvisoryServices->toArray())->get()
        );

        $ServicesCounts = ServicesReservations::where('transaction_complete', 1)
            ->select('type_id', DB::raw('count(*) as total'))
            ->groupBy('type_id')
            ->orderBy('total', 'DESC')
            ->pluck('total', 'type_id');
        $topServices = $ServicesCounts->sortDesc()->keys();
        $services = ServicesResource::collection(Service::whereIn('id', $topServices->toArray())->limit(3)->get());

        $AppointmentCounts = Reservation::where('transaction_complete', 1)
            ->select('reservation_type_id', DB::raw('count(*) as total'))
            ->groupBy('reservation_type_id')
            ->orderBy('total', 'DESC')
            ->pluck('total', 'reservation_type_id');

        $topAppointments = $AppointmentCounts->sortDesc()->keys();

        $appointments = ReservationTypeResource::collection(ReservationType::whereIn('id', $topAppointments)->limit(3)->get());

        $mostBought = ["advisoryServices" => $advisoryServices, "services" => $services, "appointments" => $appointments];

        $adivsoryServicesLatest = AdvisoryServicesSubCategoriesResource::collection(AdvisoryServicesSubCategory::orderByDesc("created_at")->limit(1)->get());
        $servicesLatest = ServicesResource::collection(Service::orderByDesc("created_at")->limit(1)->get());
        $appointmentsLatest = ReservationTypeResource::collection(ReservationType::orderByDesc("created_at")->limit(1)->get());

        $latestCreated = ["advisoryServices" => $adivsoryServicesLatest, "services" => $servicesLatest, "appointments" => $appointmentsLatest];
        return $this->sendResponse(true, 'Most Bought products', compact(
            'mostBought',
            'latestCreated'
        ), 200);
    }
}
