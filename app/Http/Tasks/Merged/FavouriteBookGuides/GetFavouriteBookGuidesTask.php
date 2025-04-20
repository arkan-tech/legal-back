<?php

namespace App\Http\Tasks\Merged\FavouriteBookGuides;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\FavouriteBookGuide;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\FavouriteBookGuide\FavouriteBookGuideResource;

class GetFavouriteBookGuidesTask extends BaseTask
{
    public function run(Request $request)
    {
        $user = $this->authAccount();

        $favouriteBookGuides = FavouriteBookGuide::where('account_id', $user->id)
            ->with('section')
            ->get();

        return $this->sendResponse(
            true,
            'Favourite Book Guides',
            ['favouriteBookGuides' => FavouriteBookGuideResource::collection($favouriteBookGuides)],
            200
        );
    }
}
