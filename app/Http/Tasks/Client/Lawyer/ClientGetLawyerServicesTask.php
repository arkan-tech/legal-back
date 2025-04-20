<?php

namespace App\Http\Tasks\Client\Lawyer;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerServicesPriceResource;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyersServicesPrice;

class ClientGetLawyerServicesTask extends BaseTask
{

    public function run($id)
    {
        $lawyer = Lawyer::findOrFail($id);
        $lawyerServicesPrices = LawyersServicesPrice::where('lawyer_id', $id)->where('isHidden', false)
            ->with('service', 'importance', 'dates.times')
            ->get();

        $resourceData = [
            'lawyer' => $lawyer,
            'services' => $lawyerServicesPrices,
        ];

        $lawyerWithServices = new LawyerWithServicesResource($resourceData);

        return $this->sendResponse(true, 'خدمات مقدم الخدمة', compact('lawyerWithServices'), 200);
    }
}
