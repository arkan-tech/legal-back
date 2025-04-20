<?php

namespace App\Http\Tasks\Lawyer\ContactYmtaz;

use App\Http\Requests\API\Lawyer\ContactYmtaz\LawyerSaveContactMessageRequest;
use App\Http\Resources\API\Client\ContactYmtaz\ClientContactYmtazResource;
use App\Http\Tasks\BaseTask;
use App\Models\LawyerYmtazContact\LawyerYmtazContact;

class LawyerSaveContactMessageTask extends BaseTask
{

    public function run(LawyerSaveContactMessageRequest $request)
    {
        $Lawyer = $this->authLawyer();
        $message = LawyerYmtazContact::create([
                'lawyer_id'=>$Lawyer->id,
               'subject'=>$request->subject,
               'details'=>$request->details,
           ]
       );
        if ($request->has('file')) {
            $message->file = saveImage($request->file('file'), 'uploads/lawyer/contacts_ymtaz/');
            $message->save();
        }
        $message =new  ClientContactYmtazResource($message);
        return $this->sendResponse(true, 'رسائل يمتاز', compact('message'), 200);
    }
}
