<?php

namespace App\Http\Tasks\Client\Services;

use App\Http\Tasks\BaseTask;
use App\Http\Resources\AccountResource;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Http\Resources\AccountResourcePublic;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Resources\API\Services\ServicesShortResource;
use App\Http\Resources\API\Lawyer\LawyerServicesPriceResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;

class ClientGetLawyersByServiceIdTask extends BaseTask
{
    public function run($request, $service_id)
    {
        $importance_id = $request->query('importance_id');
        $lawyers = LawyersServicesPrice::where('service_id', $service_id)
            ->where('isHidden', 0)
            ->when($importance_id, function ($query, $importance_id) {
                return $query->where('client_reservations_importance_id', $importance_id);
            })
            ->with([
                'lawyer.lawyerDetails' => function ($query) {
                    $query->notAdvisor();
                },
                'service',
                'importance'
            ])
            ->get();

        $lawyers = LawyerServicesPriceResourceInternal::collection($lawyers);
        return $this->sendResponse(true, 'Lawyers fetched successfully', $lawyers, 200);
    }
}

class LawyerServicesPriceResourceInternal extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'service' => new ServicesShortResource($this->service),
            'importance' => new ClientReservationsImportanceResource($this->importance),
            'lawyer' => new AccountResourcePublic($this->lawyer),
        ];
    }
}
