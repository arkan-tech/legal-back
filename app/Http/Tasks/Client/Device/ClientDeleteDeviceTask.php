<?php

namespace App\Http\Tasks\Client\Device;

use App\Http\Requests\API\Client\Device\ClientCreateDeviceRequest;
use App\Http\Requests\API\Client\Device\ClientDeleteDeviceRequest;
use App\Http\Resources\API\YmtazSettings\YmtazWorkDaysResource;
use App\Http\Tasks\BaseTask;
use App\Models\Devices\ClientFcmDevice;
use App\Models\YmtazSettings\YmtazWorkDays;
use Illuminate\Http\Request;

class ClientDeleteDeviceTask extends BaseTask
{

    public function run(ClientDeleteDeviceRequest $request,$device_id)
    {
        $user = $this->authClient();

        $device = ClientFcmDevice::where('device_id',$device_id)->where('client_id',$user->id)->first();
        if(!is_null($device))
        {
            $device->delete();

            return $this->sendResponse(true,'تم ازالة الجهاز بنجاح',null,200);
        }

        return $this->sendResponse(false,'الجهاز غير موجود',null,404);
    }
}
