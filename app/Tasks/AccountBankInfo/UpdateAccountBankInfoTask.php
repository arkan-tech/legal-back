<?php

namespace App\Tasks\AccountBankInfo;

use App\Http\Requests\UpdateAccountBankInfoRequest;
use App\Http\Resources\AccountBankInfoResource;
use App\Http\Tasks\BaseTask;
use App\Models\AccountBankInfo;

class UpdateAccountBankInfoTask extends BaseTask
{
    public function run(UpdateAccountBankInfoRequest $data)
    {
        $accountId = $this->authAccount()->id;

        $accountBankInfo = AccountBankInfo::updateOrCreate(
            ['account_id' => $accountId],
            ['bank_name' => $data['bank_name'], 'account_number' => $data['account_number']]
        );

        $account_bank_info = new AccountBankInfoResource($accountBankInfo);

        return $this->sendResponse(
            true,
            'Account bank info updated successfully',
            compact('account_bank_info'),
            200
        );

    }
}
