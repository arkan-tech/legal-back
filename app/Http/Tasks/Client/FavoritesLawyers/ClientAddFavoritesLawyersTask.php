<?php

namespace App\Http\Tasks\Client\FavoritesLawyers;

use App\Http\Requests\API\Client\FavoritesLawyers\ClientAddFavoritesLawyersRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientsFavoritesLawyers;
use Illuminate\Http\Request;

class ClientAddFavoritesLawyersTask extends BaseTask
{

    public function run(ClientAddFavoritesLawyersRequest $request)
    {
        $client = $this ->authClient();

        $fav_list = ClientsFavoritesLawyers::where('client_id',$client->id)->pluck('lawyer_id')->toArray();
        if (in_array($request->lawyer_id,$fav_list)){
          $fav =   ClientsFavoritesLawyers::where('client_id',$client->id)->where( 'lawyer_id',$request->lawyer_id)->delete();

            return $this->sendResponse(true, '  تم ازالة مقدم الخدمة من القائمة المفضلة بنجاح', null, 200);

        }
        ClientsFavoritesLawyers::create([
           'client_id'=>$client->id,
           'lawyer_id'=>$request->lawyer_id,
        ]);
        return $this->sendResponse(true, '  تم اضافة مقدم الخدمة الى القائمة المفضلة بنجاح', null, 200);
    }
}
