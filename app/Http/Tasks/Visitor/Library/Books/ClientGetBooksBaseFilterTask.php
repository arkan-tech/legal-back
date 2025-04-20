<?php

namespace App\Http\Tasks\Visitor\Library\Books;

use App\Http\Requests\API\Visitor\Library\ClientGetBooksBaseFilterRequest;
use App\Http\Resources\API\Library\Books\BooksResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\Books\Book;
use App\Models\Library\LibraryCat;
use Illuminate\Http\Request;

class ClientGetBooksBaseFilterTask extends BaseTask
{

    public function run(ClientGetBooksBaseFilterRequest $request)
    {
        $query = Book::query();

        $query->when($request->has('title') && !is_null($request->title), function ($q) use ($request) {
            $q->where('Title', 'LIKE', "%$request->title%");
        });

        $query->when($request->has('author') && !is_null($request->author), function ($q) use ($request) {
            $q->where('author', 'LIKE', "%$request->author%");
        });

        $books = $query->orderBy('created_at', 'desc')->get();
        $books = BooksResource::collection($books);
        return $this->sendResponse(true, 'الكتب', compact('books'), 200);
    }
}
