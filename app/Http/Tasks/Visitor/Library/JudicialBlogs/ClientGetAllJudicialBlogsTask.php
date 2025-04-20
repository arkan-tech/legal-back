<?php

namespace App\Http\Tasks\Visitor\Library\JudicialBlogs;

use App\Http\Resources\API\Library\RulesAndRegulationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\JudicialBlogs;
use Illuminate\Http\Request;

class ClientGetAllJudicialBlogsTask extends BaseTask
{

    public function run(Request $request)
    {
        $items = RulesAndRegulationsResource::collection(JudicialBlogs::orderBy('created_at', 'desc')->get());
        return $this->sendResponse(true, 'المدونات القضائية', compact('items'), 200);
    }
}
