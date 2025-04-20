<?php

namespace App\Http\Tasks\Merged\FavouriteLawyers;

use App\Http\Tasks\BaseTask;
use App\Models\FavouriteLawyers;
use Illuminate\Http\Request;

class CreateFavouriteTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $user = auth()->user();
        $reserverType = "lawyer";
        if (auth()->guard('api_lawyer')->check()) {
            $reserverType = "lawyer";
            if ($id == $user->id) {
                return $this->sendResponse(true, 'لا يمكن اضافة نفسك الى المفضلة', null, 400);
            }
            $favouriteLawyer = FavouriteLawyers::where('lawyer_id', $user->id)->where('fav_lawyer_id', $id)->first();
        }
        if (auth()->guard('api_client')->check()) {
            $reserverType = "client";
            $favouriteLawyer = FavouriteLawyers::where('service_user_id', $user->id)->where('fav_lawyer_id', $id)->first();
        }

        if ($favouriteLawyer) {
            $favouriteLawyer->delete();
            return $this->sendResponse(true, 'تم ازالته من المفضلة بنجاح', null, 200);
        } else {
            $favouriteLawyer = new FavouriteLawyers();
            $favouriteLawyer->fav_lawyer_id = $id;
            $favouriteLawyer->lawyer_id = $reserverType == "lawyer" ? $user->id : null;
            $favouriteLawyer->service_user_id = $reserverType == "client" ? $user->id : null;
            $favouriteLawyer->userType = $reserverType;
            $favouriteLawyer->save();
            return $this->sendResponse(true, 'تم اضافته الى المفضلة بنجاح', null, 200);
        }

    }
}
