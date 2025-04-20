<?php

namespace App\Http\Controllers\API\Merged;

use App\Http\Tasks\Merged\GetBanners;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;

class BannersController extends BaseController
{
    //
    public function getBanners(Request $request, GetBanners $task)
    {
        $response = $task->run();
        return $this->sendResponse($response["status"], $response["message"], $response["data"], $response['code']);
    }
}
