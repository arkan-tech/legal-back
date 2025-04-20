<?php

namespace App\Http\Tasks\Client\Lawyer\Rate;

use App\Http\Requests\API\Client\FavoritesLawyers\ClientAddFavoritesLawyersRequest;
use App\Http\Requests\API\Client\Lawyer\Rate\ClientCreateLawyerRateRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientsFavoritesLawyers;
use App\Models\Lawyer\LawyerRates;
use Illuminate\Http\Request;

class ClientCreateLawyerRateTask extends BaseTask
{

    public function run(ClientCreateLawyerRateRequest $request)
    {
        $client = $this ->authClient();


        LawyerRates::create([
           'client_id'=>$client->id,
           'lawyer_id'=>$request->lawyer_id,
           'rate'=>$request->rate,
           'comment'=>$request->comment,
        ]);
        return $this->sendResponse(true, '  تم اضافة التقييم بنجاح', null, 200);
    }
}
