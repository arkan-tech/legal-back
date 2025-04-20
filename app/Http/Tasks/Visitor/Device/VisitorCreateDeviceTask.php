<?php

namespace App\Http\Tasks\Visitor\Device;

use App\Http\Requests\API\Client\Device\ClientCreateDeviceRequest;
use App\Http\Requests\API\Visitor\Device\VisitorCreateDeviceRequest;
use App\Http\Resources\API\YmtazSettings\YmtazWorkDaysResource;
use App\Http\Tasks\BaseTask;
use App\Models\Devices\ClientFcmDevice;
use App\Models\VisitorFCM;
use App\Models\YmtazSettings\YmtazWorkDays;
use Illuminate\Http\Request;

class VisitorCreateDeviceTask extends BaseTask
{

    public function run(VisitorCreateDeviceRequest $request)
    {
        $user = $this->authClient();
        $device = VisitorFCM::where('device_id', $request->device_id)->first();
        if (is_null($device)) {
            VisitorFCM::create(array_merge($request->all(), ['client_id' => $user->id]));
            return $this->sendResponse(true, 'تم حفظ معلومات الجهاز', null, 200);
        } else {
            $device->update(['fcm_token' => $request->fcm_token, 'type' => $request->type, 'client_id' => $user->id]);

            return $this->sendResponse(true, 'تم تحديث معلومات الجهاز', null, 200);
        }
    }
}
