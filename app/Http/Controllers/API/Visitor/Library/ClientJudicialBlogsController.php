<?php

namespace App\Http\Controllers\API\Visitor\Library;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Visitor\Library\getAllJudicialBlogsBaseFilterRequest;
use App\Http\Tasks\Visitor\Library\JudicialBlogs\ClientGetAllJudicialBlogsBaseFilterTask;
use App\Http\Tasks\Visitor\Library\JudicialBlogs\ClientGetAllJudicialBlogsTask;
use App\Http\Tasks\Visitor\Library\JudicialBlogs\ClientGetJudicialBlogsBaseIdTask;
use App\Http\Tasks\Visitor\Library\JudicialBlogs\ClientGetJudicialBlogsDataBaseIdTask;
use Illuminate\Http\Request;

class ClientJudicialBlogsController extends BaseController
{

    public function getAllJudicialBlogs(Request $request, ClientGetAllJudicialBlogsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }


    public function getJudicialBlogsBaseSubCategoryId(Request $request, ClientGetJudicialBlogsBaseIdTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }


    public function getJudicialBlogsData(Request $request, ClientGetJudicialBlogsDataBaseIdTask $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getAllJudicialBlogsBaseFilter(getAllJudicialBlogsBaseFilterRequest $request, ClientGetAllJudicialBlogsBaseFilterTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
}
