<?php

namespace App\Http\Tasks\Visitor\Library;

use App\Http\Resources\API\Library\Books\BooksCategoryResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\LibraryCat;
use Illuminate\Http\Request;

class ClientGetAllLibraryCategoriesTask extends BaseTask
{

    public function run(Request $request)
    {
        $categories =BooksCategoryResource::collection(LibraryCat::where('parent','0')->orderBy('created_at','desc')->get()) ;
        return $this->sendResponse(true, 'المكتبة والأنظمة', compact('categories'), 200);
    }
}
