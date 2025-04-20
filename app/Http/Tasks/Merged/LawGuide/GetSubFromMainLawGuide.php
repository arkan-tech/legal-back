<?php

namespace App\Http\Tasks\Merged\LawGuide;

use App\Models\LawGuide;
use App\Http\Tasks\BaseTask;
use App\Http\Resources\LawGuideResourceShort;


class GetSubFromMainLawGuide extends BaseTask
{

    public function run($id)
    {
        $subCategories = LawGuide::where('category_id', $id)->orderBy('order')->get();

        $subCategories = $subCategories->map(function ($category) {
            return new LawGuideResourceShort($category, true);
        });

        return $this->sendResponse(true, 'Law Guides', compact('subCategories'), 200);
    }
}
