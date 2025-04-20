<?php

namespace App\Http\Tasks\Merged\Books;

use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Models\BooksSubCategories;
use App\Http\Resources\BooksResource;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Models\JudicialGuide\JudicialGuideSubCategory;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Http\Resources\API\JudicialGuide\JudicialGuideResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideSubCategoryResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;

class GetBooks extends BaseTask
{

    public function run($id)
    {
        $booksSubCategory = BooksSubCategories::findOrFail($id);

        $books = BooksResource::collection($booksSubCategory->books);
        return $this->sendResponse(true, 'Books', compact('books'), 200);
    }
}
