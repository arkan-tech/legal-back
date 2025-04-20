<?php

namespace App\Http\Tasks\Lawyer\Auth\Register;

use App\Http\Requests\API\Lawyer\Auth\Register\LawyerCheckVerificationFirstStepRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\LawyerFirstStepVerefication;

class LawyerCheckVerificationFirstStepTask extends BaseTask
{
    public function run(LawyerCheckVerificationFirstStepRequest $request)
    {
        $record = LawyerFirstStepVerefication::where('phone_code', $request->phone_code)
            ->where('phone', $request->phone)
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();
        if (!is_null($record)) {
            $record->delete();
            return $this->sendResponse(true, 'تم التأكيد بنجاح', null, 200);
        } else {
            return $this->sendResponse(true, 'التحقق خطأ ', null, 422);

        }


    }

}
