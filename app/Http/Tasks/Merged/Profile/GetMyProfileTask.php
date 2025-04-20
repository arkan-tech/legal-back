<?php

namespace App\Http\Tasks\Merged\Profile;

use GuzzleHttp\Client;
use App\Models\Account;
use App\Http\Tasks\BaseTask;
use App\Http\Resources\AccountResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetMyProfileTask extends BaseTask
{

    public function run()
    {
        $user = Account::find(auth()->user()->id);
        // dd($user);
        $user->clientGamification()->incrementStreak();
        // $httpClient = new Client();
        // $jsonData = [
        //     "userId" => $user->id
        // ];
        // $httpRequest = $httpClient->postAsync(env('JS_API_URL') . 'get-stream/createToken', [
        //     'json' => $jsonData
        // ]);
        // $httpRequest->wait();





        $account = Account::find($user->id);

        $token = JWTAuth::fromUser($account);
        $account->injectToken($token);


        $account = new AccountResource($user);
        return $this->sendResponse(true, 'My Profile data', compact('account'), 200);
    }
}