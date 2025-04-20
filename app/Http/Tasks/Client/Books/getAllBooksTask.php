<?php

namespace App\Http\Tasks\Client\Books;

use App\Http\Resources\API\Library\Books\BooksResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\Books\Book;

class getAllBooksTask extends BaseTask
{

    public function run()
    {
        $books =BooksResource::collection(Book::orderBy('created_at','desc')->get()) ;
        return $this->sendResponse(true, 'قائمة الكتب', compact('books'), 200);
    }
}
