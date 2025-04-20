<?php

namespace App\Tasks\AccountBankInfo;

use App\Http\Tasks\BaseTask;
use App\Models\AccountBankInfo;
use App\Http\Resources\AccountBankInfoResource;

class ShowAccountBankInfoTask extends BaseTask
{
    public function run()
    {
        $accountId = $this->authAccount()->id;
        $account_bank_info = AccountBankInfo::where('account_id', $accountId)->first();
        if (!$account_bank_info) {
            $account_bank_info = new \stdClass();

            return $this->sendResponse(true, 'Account Bank Info', compact('account_bank_info'), 200);
        }
        $account_bank_info = new AccountBankInfoResource($account_bank_info);
        return $this->sendResponse(true, 'Account Bank Info', compact('account_bank_info'), 200);
    }
}
