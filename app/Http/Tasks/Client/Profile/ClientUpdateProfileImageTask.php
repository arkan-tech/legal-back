<?php

namespace App\Http\Tasks\Client\Profile;

use App\Http\Requests\API\Client\Profile\ClientUpdateProfileImageRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Tasks\BaseTask;

class ClientUpdateProfileImageTask extends BaseTask
{

    public function run(ClientUpdateProfileImageRequest $request)
    {
        $client = $this->authClient();
        $client->update([
           'image'=>saveImage($request->image,'uploads/client/profile/image')
        ]);
        $client = new ClientDataResource($client);
        return $this->sendResponse(true, 'تم تحديث الصورة بنجاح', compact('client'), 200);
    }
}
