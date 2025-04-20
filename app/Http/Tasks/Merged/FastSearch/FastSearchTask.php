<?php

namespace App\Http\Tasks\Merged\FastSearch;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use App\Http\Resources\AccountResource;
use App\Models\JudicialGuide\JudicialGuide;
use App\Http\Resources\AccountResourceShort;
use App\Models\Reservations\ReservationType;
use App\Http\Resources\AccountResourcePublic;
use App\Http\Resources\API\Lawyer\LawyerDataResource;

use App\Http\Resources\API\Services\ServicesResource;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideResource;
use App\Http\Resources\API\Reservations\ReservationTypeResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;


class FastSearchTask extends BaseTask
{

    public function run(Request $request)
    {
        $user = auth()->user();

        $query = $request->query('name');

        $lawyers = Account::where('name', 'like', '%' . $query . '%')->where('status', 2)->get();
        $lawyers = AccountResourcePublic::collection($lawyers);

        // $services = Service::where('title', 'like', '%' . $query . '%')->where('isHidden', 0)->get();
        // $services = ServicesResource::collection($services);

        // $advisoryServicesTypes = AdvisoryServicesTypes::where('title', 'like', '%' . $query . '%')->where('isHidden', 0)->get();
        // $advisoryServicesTypes = AdvisoryServicesTypesResource::collection($advisoryServicesTypes);

        $judicialGuide = JudicialGuide::where('name', 'like', '%' . $query . '%')->get();
        $judicialGuide = JudicialGuideResource::collection($judicialGuide);

        // $appointmentTypes = ReservationType::where('name', 'like', '%' . $query . '%')->where('isHidden', 0)->get();
        // $appointmentTypes = ReservationTypeResource::collection($appointmentTypes);
        return $this->sendResponse(true, 'Fast Search Results', compact('lawyers', 'judicialGuide'), 200);
    }
}
