<?php

namespace App\Http\Tasks\Visitor\Library\JudicialBlogs;

use App\Http\Requests\API\Visitor\Library\getAllJudicialBlogsBaseFilterRequest;
use App\Http\Resources\API\Library\RulesAndRegulationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\JudicialBlogs;
use App\Models\Library\RulesAndRegulations;

class ClientGetAllJudicialBlogsBaseFilterTask extends BaseTask
{

    public function run(getAllJudicialBlogsBaseFilterRequest $request)
    {
        $query = JudicialBlogs::query();
        $query->when($request->has('category_id'), function ($q) use ($request) {
            $q->where('category_id', $request->category_id);
        });
        $query->when($request->has('sub_category_id'), function ($q) use ($request) {
            $q->where('sub_category_id', $request->sub_category_id);
        });
        $query->when($request->has('name'), function ($q) use ($request) {
            $q->where('name', 'LIKE', "%$request->name%");
        });
        $query->when($request->has('text'), function ($q) use ($request) {
            $q->where('text', 'LIKE', "%$request->text%");
        });
        $items = $query->orderBy('created_at', 'desc')->get();
        $items = RulesAndRegulationsResource::collection($items);
        return $this->sendResponse(true, 'المدونات القضائية', compact('items'), 200);
    }
}
