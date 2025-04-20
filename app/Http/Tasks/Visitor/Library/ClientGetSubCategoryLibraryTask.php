<?php

namespace App\Http\Tasks\Visitor\Library;

use App\Http\Resources\API\Library\Books\BooksCategoryResource;
use App\Http\Tasks\BaseTask;
use App\Models\Library\LibraryCat;
use Illuminate\Http\Request;

class ClientGetSubCategoryLibraryTask extends BaseTask
{

    public function run(Request $request , $id)
    {
        $category = LibraryCat::findOrFail($id);

        $sub_categories =BooksCategoryResource::collection(LibraryCat::where('parent',$id)->orderBy('created_at','desc')->get()) ;
        return $this->sendResponse(true, $category->title, compact('sub_categories'), 200);
    }
}
