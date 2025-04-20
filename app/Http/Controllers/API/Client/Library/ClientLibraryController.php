<?php

namespace App\Http\Controllers\API\Client\Library;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Visitor\Library\ClientGetBooksBaseFilterRequest;
use App\Http\Tasks\Visitor\Library\Books\ClientGetBooksBaseFilterTask;
use App\Http\Tasks\Visitor\Library\Books\ClientGetBooksBaseSubCategoryIdTask;
use App\Http\Tasks\Visitor\Library\Books\ClientGetBooksDetailsBaseIdTask;
use App\Http\Tasks\Visitor\Library\ClientGetAllLibraryCategoriesTask;
use App\Http\Tasks\Visitor\Library\ClientGetSubCategoryLibraryTask;
use Illuminate\Http\Request;

class ClientLibraryController extends BaseController
{

    public function getAllLibraryCategories(Request $request, ClientGetAllLibraryCategoriesTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getBooksBaseFilter(ClientGetBooksBaseFilterRequest $request, ClientGetBooksBaseFilterTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getSubCategoryLibrary(Request $request, ClientGetSubCategoryLibraryTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getBooksBaseSubCategoryId(Request $request, ClientGetBooksBaseSubCategoryIdTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getBooksDetailsBaseId(Request $request, ClientGetBooksDetailsBaseIdTask $task, $id)
    {
        $response = $task->run($request, $id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

}
