<?php

namespace App\Http\Tasks\Merged\FCM;

use App\Http\Requests\API\Client\Device\ClientCreateDeviceRequest;
use App\Http\Requests\API\Client\Device\ClientDeleteDeviceRequest;
use App\Http\Resources\API\YmtazSettings\YmtazWorkDaysResource;
use App\Http\Tasks\BaseTask;
use App\Models\AccountFcm;
use App\Models\Devices\ClientFcmDevice;
use App\Models\YmtazSettings\YmtazWorkDays;
use Illuminate\Http\Request;

class AccountDeleteDeviceTask extends BaseTask
{

    public function run(ClientDeleteDeviceRequest $request, $device_id)
    {
        $account = $this->authAccount();

        $device = AccountFcm::where(['device_id' => $device_id, 'account_id' => $account->id])->first();
        if (!is_null($device)) {
            $device->delete();

            return $this->sendResponse(true, 'تم ازالة الجهاز بنجاح', null, 200);
        }

        return $this->sendResponse(false, 'الجهاز غير موجود', null, 404);
    }
}
