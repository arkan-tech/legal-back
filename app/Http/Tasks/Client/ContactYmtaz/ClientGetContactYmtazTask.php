<?php

namespace App\Http\Tasks\Client\ContactYmtaz;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\ContactYmtaz\ClientContactYmtazResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientsContact;

class ClientGetContactYmtazTask extends BaseTask
{

    public function run()
    {
        $client = $this->authClient();
        $messages = ClientsContact::where('client_id', $client->id)->orderBy('created_at','desc')->get();
        $messages = ClientContactYmtazResource::collection($messages);
        return $this->sendResponse(true, 'رسائل يمتاز', compact('messages'), 200);
    }
}
