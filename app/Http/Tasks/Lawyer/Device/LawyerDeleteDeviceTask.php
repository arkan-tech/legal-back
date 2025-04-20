<?php

namespace App\Http\Tasks\Lawyer\Device;


use App\Http\Requests\API\Lawyer\Device\LawyerDeleteDeviceRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Devices\LawyerFcmDevice;
use Illuminate\Http\Request;

class LawyerDeleteDeviceTask extends BaseTask
{

    public function run(LawyerDeleteDeviceRequest $request,$device_id)
    {
        $user = $this->authLawyer();

        $device = LawyerFcmDevice::where('device_id',$device_id)->where('lawyer_id',$user->id)->first();
        if(!is_null($device))
        {

            $device->delete();

            return $this->sendResponse(true,'تم ازالة الجهاز بنجاح',null,200);
        }

        return $this->sendResponse(false,'الجهاز غير موجود',null,404);
    }

}
