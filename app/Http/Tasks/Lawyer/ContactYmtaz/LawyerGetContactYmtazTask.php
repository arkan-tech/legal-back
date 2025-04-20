<?php

namespace App\Http\Tasks\Lawyer\ContactYmtaz;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\ContactYmtaz\ClientContactYmtazResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientsContact;
use App\Models\LawyerYmtazContact\LawyerYmtazContact;

class LawyerGetContactYmtazTask extends BaseTask
{

    public function run()
    {
        $lawyer = $this->authLawyer();
        $messages = LawyerYmtazContact::where('lawyer_id', $lawyer->id)->orderBy('created_at','desc')->get();
        $messages = ClientContactYmtazResource::collection($messages);
        return $this->sendResponse(true, 'رسائل يمتاز', compact('messages'), 200);
    }
}
