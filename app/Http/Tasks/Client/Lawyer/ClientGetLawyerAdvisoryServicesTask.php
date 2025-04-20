<?php

namespace App\Http\Tasks\Client\Lawyer;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Http\Resources\API\Lawyer\LawyerServicesPriceResource;

class ClientGetLawyerAdvisoryServicesTask extends BaseTask
{

    public function run($id)
    {
        $lawyer = Account::where('account_type', 'lawyer')->findOrFail($id);
        $lawyerSectionsIds = $lawyer->lawyerDetails->SectionsRel->pluck('section_id')->toArray();
        $lawyerAdvisoryServices = AdvisoryServices::with([
            'types.advisory_services_prices.importance',
            'types.advisory_services_prices' => function ($query) use ($id) {
                $query->where('account_id', $id)->where('is_ymtaz', 0);
            },
            'types' => function ($query) use ($id) {
                $query->whereHas('advisory_services_prices', function ($query) use ($id) {
                    $query->where('account_id', $id)->where('is_ymtaz', 0)->where('isHidden', false);
                });
            }
        ])
            ->whereHas('types.advisory_services_prices', function ($query) use ($id) {
                $query->where('account_id', $id)->where('is_ymtaz', 0);
            })->get();

        return $this->sendResponse(true, 'استشارات مقدم الخدمة', compact('lawyerAdvisoryServices'), 200);
    }
}
