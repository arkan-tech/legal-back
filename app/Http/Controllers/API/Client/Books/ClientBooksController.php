<?php

namespace App\Http\Controllers\API\Client\Books;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Client\Book\addBookFavRequest;
use App\Http\Requests\API\Client\Book\addBookRateRequest;
use App\Http\Tasks\Client\Books\addBookFavTask;
use App\Http\Tasks\Client\Books\addBookRateTask;
use App\Http\Tasks\Client\Books\getAllBooksTask;
use App\Http\Tasks\Client\Books\listBookFavTask;
use Illuminate\Http\Request;

class ClientBooksController extends BaseController
{
    public function index(Request $request , getAllBooksTask $task){
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function addRate(addBookRateRequest $request , addBookRateTask $task){
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function addFav(addBookFavRequest $request , addBookFavTask $task){
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function listFav(Request $request , listBookFavTask $task){
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
