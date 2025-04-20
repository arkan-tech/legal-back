<?php

namespace App\Http\Tasks\Visitor\Library\RulesAndRegulations;

use App\Http\Resources\API\Library\RulesAndRegulationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\RulesAndRegulations;

class ClientGetRulesAndRegulationsDataTask extends BaseTask
{

    public function run($id)
    {
        $item = RulesAndRegulations::findOrFail($id);
        $item = new RulesAndRegulationsResource($item);
        return $this->sendResponse(true, '   الأنظمة واللوائح', compact('item'), 200);
    }
}
