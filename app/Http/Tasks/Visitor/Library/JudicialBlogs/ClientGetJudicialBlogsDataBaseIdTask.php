<?php

namespace App\Http\Tasks\Visitor\Library\JudicialBlogs;

use App\Http\Resources\API\Library\RulesAndRegulationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\JudicialBlogs;

class ClientGetJudicialBlogsDataBaseIdTask extends BaseTask
{

    public function run($id)
    {
        $item = JudicialBlogs::findOrFail($id);
        $item = new RulesAndRegulationsResource($item);
        return $this->sendResponse(true, 'المدونات القضائية', compact('item'), 200);
    }
}
