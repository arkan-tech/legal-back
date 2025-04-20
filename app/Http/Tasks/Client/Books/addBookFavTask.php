<?php

namespace App\Http\Tasks\Client\Books;

use App\Http\Requests\API\Client\Book\addBookFavRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Library\Books\ClientBookFavorite;

class addBookFavTask extends BaseTask
{

    public function run(addBookFavRequest $request)
    {
        $client= $this->authClient();
        $fav_list = ClientBookFavorite::where('client_id',$client->id)->pluck('book_id')->toArray();

        if (in_array($request->book_id,$fav_list)){
            $fav =   ClientBookFavorite::where('client_id',$client->id)->where( 'book_id',$request->book_id)->delete();
            return $this->sendResponse(true, '  تم ازالة الكتاب من قائمة المفضلة بنجاح', null, 200);
        }
        ClientBookFavorite::create([
            'client_id'=>$client->id,
            'book_id'=>$request->book_id,
        ]) ;
        return $this->sendResponse(true, '  تم اضافة الكتاب في قائمة المفضلة بنجاح  ', null, 200);
    }
}
