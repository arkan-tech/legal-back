<?php

namespace App\Http\Tasks\Visitor\Library\JudicialBlogs;

use App\Http\Resources\API\Library\RulesAndRegulationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\JudicialBlogs;
use App\Models\Library\LibraryCat;
use App\Models\Library\RulesAndRegulations;
use Illuminate\Http\Request;

class ClientGetJudicialBlogsBaseIdTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $items = RulesAndRegulationsResource::collection(JudicialBlogs::where('category_id', $id)->orWhere('sub_category_id', $id)->orderBy('created_at', 'desc')->get());
        return $this->sendResponse(true, 'الانظمة واللوائح', compact('items'), 200);
    }
}
