<?php

namespace App\Http\Tasks\Merged\Books;

use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Models\BooksMainCategories;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\BooksMainCategoriesResource;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;

class GetBooksMainCategories extends BaseTask
{

    public function run()
    {
        $booksMainCategories = BooksMainCategories::get();
        $booksMainCategories = BooksMainCategoriesResource::collection($booksMainCategories);
        return $this->sendResponse(true, 'Books Main Categories', compact('booksMainCategories'), 200);
    }
}
