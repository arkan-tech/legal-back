<?php

namespace App\Http\Tasks\Merged\BookGuide;

use App\Models\LawGuide;
use App\Models\BookGuide;
use App\Http\Tasks\BaseTask;
use App\Http\Resources\LawGuideResourceShort;
use App\Http\Resources\BookGuideResourceShort;


class GetSubFromMainBookGuide extends BaseTask
{

    public function run($id)
    {
        $subCategories = BookGuide::where('category_id', $id)->get();

        $subCategories = $subCategories->map(function ($category) {
            return new BookGuideResourceShort($category, true);
        });

        return $this->sendResponse(true, 'Book Guides', compact('subCategories'), 200);
    }
}
