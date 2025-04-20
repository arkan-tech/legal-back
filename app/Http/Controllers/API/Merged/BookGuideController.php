<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Http\Tasks\Merged\Auth\ConfirmOtp;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\LawGuide\GetLawById;
use App\Http\Tasks\Merged\BookGuide\GetBookById;
use App\Http\Tasks\Merged\LawGuide\GetSubLawGuide;
use App\Http\Tasks\Merged\LawGuide\GetMainLawGuide;
use App\Http\Tasks\Merged\LawGuide\SearchLawGuides;
use App\Http\Tasks\Merged\BookGuide\GetSubBookGuide;
use App\Http\Tasks\Merged\Auth\ResendConfirmationOtp;
use App\Http\Tasks\Merged\BookGuide\GetMainBookGuide;
use App\Http\Tasks\Merged\BookGuide\SearchBookGuides;
use App\Http\Tasks\Merged\LawGuide\GetLawsFromSubLawGuide;
use App\Http\Tasks\Merged\LawGuide\GetSubFromMainLawGuide;
use App\Http\Tasks\Merged\BookGuide\GetSubFromMainBookGuide;

class BookGuideController extends BaseController
{
    public function getMain(Request $request, GetMainBookGuide $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getSubFromMain(Request $request, GetSubFromMainBookGuide $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getSubLawGuide(Request $request, GetSubBookGuide $task, $subId)
    {
        $response = $task->run($request, $subId);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function search(Request $request, SearchBookGuides $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getBookById(Request $request, GetBookById $task, $sectionId)
    {
        $response = $task->run($sectionId);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

}
