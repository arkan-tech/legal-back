<?php

namespace App\Http\Tasks\Visitor\Library\RulesAndRegulations;

use App\Http\Resources\API\Library\RulesAndRegulationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\LibraryCat;
use App\Models\Library\RulesAndRegulations;
use Illuminate\Http\Request;

class ClientGetAllRulesAndRegulationsTask extends BaseTask
{

    public function run(Request $request)
    {
        $items = RulesAndRegulationsResource::collection(RulesAndRegulations::orderBy('created_at', 'desc')->get());
        return $this->sendResponse(true, 'الانظمة واللوائح', compact('items'), 200);
    }
}
