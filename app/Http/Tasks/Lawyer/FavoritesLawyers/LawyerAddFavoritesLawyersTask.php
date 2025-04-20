<?php

namespace App\Http\Tasks\Lawyer\FavoritesLawyers;

use App\Http\Requests\API\Lawyer\FavoritesLawyers\LawyerAddFavoritesLawyersRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientsFavoritesLawyers;
use App\Models\Lawyer\LawyerFavoritesLawyers;

class LawyerAddFavoritesLawyersTask extends BaseTask
{

    public function run(LawyerAddFavoritesLawyersRequest $request)
    {
        $client = $this->authLawyer();

        $fav_list = LawyerFavoritesLawyers::where('lawyer_id', $client->id)->pluck('fav_lawyer_id')->toArray();
        if (in_array($request->lawyer_id, $fav_list)) {
            $fav = LawyerFavoritesLawyers::where('lawyer_id', $client->id)->where('fav_lawyer_id', $request->lawyer_id)->delete();
            return $this->sendResponse(true, '  تم ازالة مقدم الخدمة من القائمة المفضلة بنجاح', null, 200);
        }
        LawyerFavoritesLawyers::create([
            'lawyer_id' => $client->id,
            'fav_lawyer_id' => $request->lawyer_id,
        ]);
        return $this->sendResponse(true, '  تم اضافة مقدم الخدمة الى القائمة المفضلة بنجاح', null, 200);
    }
}
