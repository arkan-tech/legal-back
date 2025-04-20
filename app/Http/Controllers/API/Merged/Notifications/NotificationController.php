<?php

namespace App\Http\Controllers\API\Merged\Notifications;

use App\Http\Tasks\Merged\Notifications\GetNotificationsTask;
use App\Http\Tasks\Merged\Notifications\MarkAsSeenTask;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;


class NotificationController extends BaseController
{
    public function getNotifications(Request $request, GetNotificationsTask $task)
    {

        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function markAsSeen(Request $request, MarkAsSeenTask $task)
    {

        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
}
