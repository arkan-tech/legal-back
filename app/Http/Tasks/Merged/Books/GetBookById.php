<?php

namespace App\Http\Tasks\Merged\Books;

use App\Models\Books;
use App\Http\Tasks\BaseTask;
use App\Models\API\Splash\Splash;
use App\Http\Resources\BooksResource;
use App\Models\JudicialGuide\JudicialGuide;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Models\JudicialGuide\JudicialGuideSubCategory;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Http\Resources\API\JudicialGuide\JudicialGuideResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideSubCategoryResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;

class GetBookById extends BaseTask
{

    public function run($id)
    {
        $book = Books::findOrFail($id);
        $book = new BooksResource($book);
        return $this->sendResponse(true, 'Book by id', compact('book'), 200);
    }
}
