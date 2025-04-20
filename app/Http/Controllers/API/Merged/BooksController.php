<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Http\Tasks\Merged\Books\GetBooks;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\Books\GetBookById;
use App\Http\Tasks\Merged\Books\GetBooksById;
use App\Http\Tasks\Merged\Books\GetBooksSubCategories;
use App\Http\Tasks\Merged\Books\GetBooksMainCategories;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuides;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuideById;
use App\Http\Tasks\Merged\FavouriteLawyers\CreateFavouriteTask;
use App\Http\Tasks\Merged\FavouriteLawyers\GetFavouriteLawyersTask;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuidesSubCategories;
use App\Http\Tasks\Merged\JudicialGuide\GetJudicialGuidesMainCategories;


class BooksController extends BaseController
{

    public function getMain(Request $request, GetBooksMainCategories $task)
    {
        $task = $task->run();
        return $task;
    }

    public function getSub(Request $request, GetBooksSubCategories $task, $id)
    {
        $task = $task->run($id);
        return $task;
    }
    public function getBooks(Request $request, GetBooks $task, $id)
    {
        $task = $task->run($id);
        return $task;
    }
    public function getBookById(Request $request, GetBookById $task, $id)
    {
        $task = $task->run($id);
        return $task;
    }


}
