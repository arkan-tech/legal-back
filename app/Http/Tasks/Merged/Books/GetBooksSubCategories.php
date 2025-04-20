<?php

namespace App\Http\Tasks\Merged\Books;

use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Models\BooksMainCategories;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\BooksSubCategoriesResource;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideSubCategoryResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;

class GetBooksSubCategories extends BaseTask
{

    public function run($id)
    {
        $booksMainCategory = BooksMainCategories::findOrFail($id);
        $booksSubCategories = BooksSubCategoriesResource::collection($booksMainCategory->subCategories);
        return $this->sendResponse(true, 'Books Sub Categories', compact('booksSubCategories'), 200);
    }
}
