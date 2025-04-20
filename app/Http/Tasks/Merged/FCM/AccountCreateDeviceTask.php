<?php

namespace App\Http\Tasks\Merged\FCM;

use App\Models\AccountFcm;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Devices\ClientFcmDevice;
use App\Models\YmtazSettings\YmtazWorkDays;
use App\Http\Resources\API\YmtazSettings\YmtazWorkDaysResource;
use App\Http\Requests\API\Client\Device\ClientCreateDeviceRequest;

class AccountCreateDeviceTask extends BaseTask
{

    public function run(ClientCreateDeviceRequest $request)
    {
        $account = $this->authAccount();
        $device = AccountFcm::where('device_id', $request->device_id)->first();
        if (is_null($device)) {
            AccountFcm::create(array_merge($request->all(), ['account_id' => $account->id]));
            return $this->sendResponse(true, 'تم حفظ معلومات الجهاز', null, 200);
        } else {
            $device->update(['fcm_token' => $request->fcm_token, 'type' => $request->type, 'account_id' => $account->id]);

            return $this->sendResponse(true, 'تم تحديث معلومات الجهاز', null, 200);
        }
    }
}
