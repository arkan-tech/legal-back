<?php

namespace App\Http\Tasks\Visitor\Library\Books;

use App\Http\Resources\API\Library\Books\BooksResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\Books\Book;
use App\Models\Library\LibraryCat;
use Illuminate\Http\Request;

class ClientGetBooksBaseSubCategoryIdTask extends BaseTask
{

    public function run(Request $request, $id)
    {
        $Books = Book::where('CatID', $id)->orderBy('created_at', 'desc')->get();
        $sectitle = GetName('librarycats', 'title', 'id', $id);

        $books = BooksResource::collection($Books);
        return $this->sendResponse(true, $sectitle, compact('books'), 200);
    }
}
