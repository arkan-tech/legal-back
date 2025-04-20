<?php

namespace App\Http\Tasks\Merged\FavouriteLawyers;

use App\Http\Tasks\BaseTask;
use App\Models\FavouriteLawyers;
use Illuminate\Http\Request;

class GetFavouriteLawyersTask extends BaseTask
{

    public function run(Request $request)
    {
        $user = auth()->user();
        $reserverType = "lawyer";
        if (auth()->guard('api_lawyer')->check()) {
            $reserverType = "lawyer";
            $favouriteLawyers = FavouriteLawyers::where('lawyer_id', $user->id)->with('favLawyer')->get();
        }
        if (auth()->guard('api_client')->check()) {
            $reserverType = "client";
            $favouriteLawyers = FavouriteLawyers::where('service_user_id', $user->id)->with('favLawyer')->get();
        }

        return $this->sendResponse(true, 'Favourite Lawyers', compact('favouriteLawyers'), 200);


    }
}
