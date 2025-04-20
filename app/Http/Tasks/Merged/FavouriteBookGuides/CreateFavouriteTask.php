<?php

namespace App\Http\Tasks\Merged\FavouriteBookGuides;

use App\Http\Tasks\BaseTask;
use App\Models\FavouriteBookGuide;
use Illuminate\Http\Request;

class CreateFavouriteTask extends BaseTask
{
    public function run(Request $request, $id)
    {
        $user = $this->authAccount();

        $favouriteBookGuide = FavouriteBookGuide::where('account_id', $user->id)
            ->where('section_id', $id)
            ->first();

        if ($favouriteBookGuide) {
            $favouriteBookGuide->delete();
            return $this->sendResponse(true, 'تم ازالته من المفضلة بنجاح', null, 200);
        } else {
            $favouriteBookGuide = new FavouriteBookGuide();
            $favouriteBookGuide->section_id = $id;
            $favouriteBookGuide->account_id = $user->id;
            $favouriteBookGuide->save();
            return $this->sendResponse(true, 'تم اضافته الى المفضلة بنجاح', null, 200);
        }
    }
}
