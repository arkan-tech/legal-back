<?php

namespace App\Http\Tasks\Client\FavoritesLawyers;

use App\Http\Resources\API\Client\FavoritesLawyers\ClientFavoritesLawyersResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientsFavoritesLawyers;
use Illuminate\Http\Request;

class ClientListFavoritesLawyersTask extends BaseTask
{

    public function run(Request $request)
    {

        $client = $this->authClient();
        $fav_list =ClientFavoritesLawyersResource::collection(ClientsFavoritesLawyers::where('client_id',$client->id)->orderBy('created_at','desc')->get()) ;
        return $this->sendResponse(true, '  قائمة مقدمي الخدمة المفضلين', compact('fav_list'), 200);
    }
}
