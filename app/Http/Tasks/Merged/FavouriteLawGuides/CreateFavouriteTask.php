<?php

namespace App\Http\Tasks\Merged\FavouriteLawGuides;

use App\Http\Tasks\BaseTask;
use App\Models\FavouriteLawGuide;
use Illuminate\Http\Request;

class CreateFavouriteTask extends BaseTask
{
    public function run(Request $request, $id)
    {
        $user = $this->authAccount();

        $favouriteLawGuide = FavouriteLawGuide::where('account_id', $user->id)
            ->where('law_id', $id)
            ->first();

        if ($favouriteLawGuide) {
            $favouriteLawGuide->delete();
            return $this->sendResponse(true, 'تم ازالته من المفضلة بنجاح', null, 200);
        } else {
            $favouriteLawGuide = new FavouriteLawGuide();
            $favouriteLawGuide->law_id = $id;
            $favouriteLawGuide->account_id = $user->id;
            $favouriteLawGuide->save();
            return $this->sendResponse(true, 'تم اضافته الى المفضلة بنجاح', null, 200);
        }
    }
}
