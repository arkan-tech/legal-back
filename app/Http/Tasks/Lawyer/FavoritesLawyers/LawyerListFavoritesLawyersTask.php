<?php

namespace App\Http\Tasks\Lawyer\FavoritesLawyers;

use App\Http\Resources\API\Client\FavoritesLawyers\ClientFavoritesLawyersResource;
use App\Http\Resources\API\Lawyer\FavoritesLawyers\LawyerFavoritesLawyersResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientsFavoritesLawyers;
use App\Models\Lawyer\LawyerFavoritesLawyers;
use Illuminate\Http\Request;

class LawyerListFavoritesLawyersTask extends BaseTask
{

    public function run(Request $request)
    {

        $client = $this->authLawyer();
        $fav_list =LawyerFavoritesLawyersResource::collection(LawyerFavoritesLawyers::where('lawyer_id',$client->id)->orderBy('created_at','desc')->get()) ;
        return $this->sendResponse(true, '  قائمة مقدمي الخدمة المفضلين', compact('fav_list'), 200);
    }
}
