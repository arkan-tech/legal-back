<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Tasks\BaseTask;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountResourcePublic;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\AdvisoryServices\AdvisoryServicesPrices;
use App\Http\Resources\AdvisoryServicesSubCategoriesResource;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategoryPrice;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesPricesResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;

class ClientGetLawyersByAdvisoryServiceTypeIdTask extends BaseTask
{
    public function run($request, $sub_id)
    {
        $importance_id = $request->query('importance_id');
        $lawyers = AdvisoryServicesSubCategoryPrice::where('sub_category_id', $sub_id)
            ->whereNotNull('lawyer_id')
            ->when($importance_id, function ($query, $importance_id) {
                return $query->where('importance_id', $importance_id);
            })
            ->with([
                'lawyer',
                'subCategory.generalCategory.paymentCategoryType',
            ])
            ->get();

        $lawyers = AdvisoryServicesPricesResourceInternal::collection($lawyers);
        return $this->sendResponse(true, 'Lawyers fetched successfully', $lawyers, 200);
    }
}

class AdvisoryServicesPricesResourceInternal extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'sub_category' => new AdvisoryServicesSubCategoriesResource($this->subCategory),
            'importance' => new ClientReservationsImportanceResource($this->importance),
            'lawyer' => new AccountResourcePublic($this->lawyer),
        ];
    }
}
