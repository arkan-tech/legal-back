<?php

namespace App\Http\Tasks\Admin;

use App\Models\AdminUsers;
use App\Http\Tasks\BaseTask;

class CheckIfAdminTask extends BaseTask
{
    public function run($user)
    {
        $isAdmin = AdminUsers::where('account_id', $user->id)->exists();
        return [
            'status' => true,
            'message' => 'Admin check completed',
            'data' => ['is_admin' => $isAdmin],
            'code' => 200
        ];
    }
}
