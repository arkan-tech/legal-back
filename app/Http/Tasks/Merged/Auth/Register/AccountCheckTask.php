<?php

namespace App\Http\Tasks\Merged\Auth\Register;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;

class AccountCheckTask extends BaseTask
{
    public function run(Request $request)
    {
        $account = $this->authAccount();
        if (is_null($account)) {
            return $this->sendResponse(false, 'غير موجود', null, 404);
        }

        if ($account->status == 0) {
            return $this->sendResponse(false, "لقد تم تعليق حسابكم في يمتاز بناء على طلبكم أو لسبب قررته الإدارة المختصة.
يمكنك التواصل معنا في حال كان هذا التعليق خاطئاً أو غير مبرر.", null, 403);
        }
        return $this->sendResponse(true, 'مسموح', null, 200);
    }
}
