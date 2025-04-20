<?php

namespace App\Http\Controllers\API\Merged\FastSearch;

use App\Http\Tasks\Merged\FastSearch\FastSearchTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FastSearchController extends Controller
{

    public function fastSearch(Request $request, FastSearchTask $task)
    {
        $response = $task->run($request);
        return $response;
    }
}
