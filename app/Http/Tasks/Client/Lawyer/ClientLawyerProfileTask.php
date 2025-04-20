<?php

namespace App\Http\Tasks\Client\Lawyer;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use App\Http\Resources\AccountResource;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Http\Resources\AccountResourcePublic;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerWithServicesResource;

class ClientLawyerProfileTask extends BaseTask
{

    public function run($id)
    {
        $lawyer = Account::findOrFail($id);
        $account = new AccountResourcePublic($lawyer);

        return $this->sendResponse(true, 'معلومات مقدم الخدمة', compact('account'), 200);
    }
}
