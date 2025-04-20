<?php

namespace App\Http\Tasks\Merged\Invites;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\AccountInvites;
use App\Http\Resources\AccountInviteResource;


class GetInvitesTask extends BaseTask
{

    public function run(Request $request)
    {
        $account = auth()->user();
        $invites = AccountInvites::where('account_id', '=', $account->id)->get();
        $accounts = Account::where('referred_by', $account->referralCode->referral_code)->get();
        $filteredAccounts = $accounts->reject(function ($account) use ($invites) {
            return $invites->contains(function ($invite) use ($account) {
                return $invite['email'] === $account->email ||
                    ($invite['phone'] === $account->phone && $invite['phone_code'] === $account->phone_code);
            });
        });
        $invites = AccountInviteResource::collection($invites)->toArray($request);
        $accountsThatAreInvitedArray = [];
        foreach ($filteredAccounts as $account) {
            $accountsThatAreInvitedArray[] = [
                'id' => $account->id,
                'email' => $account->email,
                'phone' => $account->phone,
                'phone_code' => $account->phone_code,
                'status' => 2,
            ];
        }
        $responseObject = array_merge($invites, $accountsThatAreInvitedArray);
        return $this->sendResponse(true, 'دعواتي', $responseObject, 200);
    }
}
