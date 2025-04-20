<?php

namespace App\Http\Tasks\Visitor\Library\RulesAndRegulations;

use App\Http\Requests\API\Visitor\Library\getAllRulesAndRegulationsBaseFilterRequest;
use App\Http\Resources\API\Library\RulesAndRegulationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\RulesAndRegulations;

class ClientGetAllRulesAndRegulationsBaseFilterTask extends BaseTask
{

    public function run(getAllRulesAndRegulationsBaseFilterRequest $request)
    {
        $query = RulesAndRegulations::query();
        $query->when($request->has('category_id'),function($q) use ($request){
            $q->where('category_id',$request->category_id);
        });
        $query->when($request->has('sub_category_id'),function($q) use ($request){
            $q->where('sub_category_id',$request->sub_category_id);
        });
        $query->when($request->has('name'),function($q) use ($request){
            $q->where('name','LIKE',"%$request->name%");
        });
        $query->when($request->has('text'),function($q) use ($request){
            $q->where('text','LIKE',"%$request->text%");
        });
        $items = $query->orderBy('created_at','desc')->get();
        $items = RulesAndRegulationsResource::collection($items);
        return $this->sendResponse(true, '   الأنظمة واللوائحس', compact('items'), 200);
    }
}
