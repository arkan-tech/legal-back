<?php

namespace App\Http\Tasks\Client\Books;

use App\Http\Requests\API\Client\Book\addBookRateRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Library\Books\BookRate;

class addBookRateTask extends BaseTask
{

    public function run(addBookRateRequest $request)
    {
        $client= $this->authClient();

        BookRate::create([
            'client_id'=>$client->id,
            'book_id'=>$request->book_id,
            'rate'=>$request->rate,
            'comment'=>$request->comment,
        ]) ;
        return $this->sendResponse(true, ' تم اضافة تقييم الكتاب', null, 200);
    }
}
