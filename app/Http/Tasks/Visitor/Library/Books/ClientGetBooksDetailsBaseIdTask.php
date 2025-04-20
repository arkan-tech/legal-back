<?php

namespace App\Http\Tasks\Visitor\Library\Books;

use App\Http\Resources\API\Library\Books\BooksResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\Books\Book;
use Illuminate\Http\Request;

class ClientGetBooksDetailsBaseIdTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $Book = Book::findOrFail($id);
        $book = new BooksResource($Book);
        return $this->sendResponse(true, $Book->Title, compact('book'), 200);
    }
}
