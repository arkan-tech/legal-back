<?php

namespace App\Http\Tasks\Client\ContactYmtaz;

use App\Http\Requests\API\Client\ContactYmtaz\SaveContactMessageRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\ContactYmtaz\ClientContactYmtazResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientsContact;

class ClientSaveContactMessageTask extends BaseTask
{

    public function run(SaveContactMessageRequest $request)
    {
        $client = $this->authClient();
       $message =  ClientsContact::create([
               'client_id'=>$client->id,
               'subject'=>$request->subject,
               'details'=>$request->details,
           ]
       );
        if ($request->has('file')) {
            $message->file = saveImage($request->file('file'), 'uploads/client/contacts_ymtaz/');
            $message->save();
        }
        $message =new  ClientContactYmtazResource($message);
        return $this->sendResponse(true, 'رسائل يمتاز', compact('message'), 200);
    }
}
