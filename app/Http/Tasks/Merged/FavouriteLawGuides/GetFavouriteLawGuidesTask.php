<?php

namespace App\Http\Tasks\Merged\FavouriteLawGuides;

use App\Http\Tasks\BaseTask;
use App\Models\FavouriteLawGuide;
use Illuminate\Http\Request;
use App\Http\Resources\API\FavouriteLawGuide\FavouriteLawGuideResource;

class GetFavouriteLawGuidesTask extends BaseTask
{
    public function run(Request $request)
    {
        $user = $this->authAccount();

        $favouriteLawGuides = FavouriteLawGuide::where('account_id', $user->id)
            ->with('law')
            ->get();

        return $this->sendResponse(
            true,
            'Favourite Law Guides',
            ['favouriteLawGuides' => FavouriteLawGuideResource::collection($favouriteLawGuides)],
            200
        );
    }
}
