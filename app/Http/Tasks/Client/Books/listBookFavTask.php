<?php

namespace App\Http\Tasks\Client\Books;

use App\Http\Resources\API\Library\Books\BooksResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\Books\Book;
use App\Models\Library\Books\ClientBookFavorite;
use Illuminate\Http\Request;

class listBookFavTask extends BaseTask
{

    public function run(Request $request)
    {
        $client= $this->authClient();
        $fav_list = ClientBookFavorite::where('client_id',$client->id)->pluck('book_id')->toArray();
        $books = BooksResource::collection(Book::whereIN('id',$fav_list)->orderBy('created_at','desc')->get());
        return $this->sendResponse(true, '  تم اضافة الكتاب في قائمة المفضلة بنجاح  ', compact('books'), 200);
    }
}
