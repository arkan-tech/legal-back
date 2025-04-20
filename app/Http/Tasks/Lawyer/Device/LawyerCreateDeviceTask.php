<?php

namespace App\Http\Tasks\Lawyer\Device;

use App\Http\Requests\API\Lawyer\Device\LawyerCreateDeviceRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Devices\LawyerFcmDevice;
use Illuminate\Http\Request;

class LawyerCreateDeviceTask extends BaseTask
{

    public function run(LawyerCreateDeviceRequest $request)
    {
        $user = $this->authLawyer();
        $device = LawyerFcmDevice::where('device_id',$request->device_id)->first();
        if(is_null($device))
        {
            LawyerFcmDevice::create(array_merge($request->all(), ['lawyer_id' => $user->id]));
            return $this->sendResponse(true,'تم حفظ معلومات الجهاز',null,200);
        } else
        {
            $device->update(['fcm_token' => $request->fcm_token,'type' => $request->type,'status' => 1,'lawyer_id' => $user->id]);

            return $this->sendResponse(true,'تم تحديث معلومات الجهاز',null,200);
        }
    }
}
