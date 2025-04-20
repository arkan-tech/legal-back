<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use App\Models\Books;
use App\Models\City\City;
use Illuminate\Http\Request;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Models\BooksSubCategories;
use App\Models\BooksMainCategories;
use App\Http\Controllers\Controller;
use App\Rules\ArrayAtLeastOneRequired;
use Google\Service\AndroidEnterprise\GoogleAuthenticationSettings;


class BooksController extends Controller
{
    public function mainIndex()
    {
        $mainCategories = BooksMainCategories::get();
        return Inertia::render('Settings/Books/Main/index', get_defined_vars());
    }

    public function subIndex()
    {
        $mainCategories = BooksMainCategories::get();
        $subCategories = BooksSubCategories::with('mainCategory')->get();
        return Inertia::render('Settings/Books/Sub/index', get_defined_vars());

    }

    public function index()
    {
        $books = Books::with('subCategory.mainCategory')->get();
        $mainCategories = BooksMainCategories::get();
        $subCategories = BooksSubCategories::with('mainCategory')->get();
        return Inertia::render('Settings/Books/index', get_defined_vars());

    }
    public function mainIndexCreate()
    {
        $mainCategories = BooksMainCategories::get();
        return Inertia::render('Settings/Books/Main/Create/index', get_defined_vars());
    }

    public function subIndexCreate()
    {
        $mainCategories = BooksMainCategories::get();

        return Inertia::render('Settings/Books/Sub/Create/index', get_defined_vars());

    }

    public function indexCreate()
    {
        $mainCategories = BooksMainCategories::get();
        $subCategories = BooksSubCategories::with('mainCategory')->get();
        return Inertia::render('Settings/Books/Create/index', get_defined_vars());

    }
    public function mainIndexEdit($id)
    {
        $mainCategory = BooksMainCategories::findOrFail($id);
        return Inertia::render('Settings/Books/Main/Edit/index', get_defined_vars());
    }

    public function subIndexEdit($id)
    {
        $mainCategories = BooksMainCategories::get();
        $subCategory = BooksSubCategories::with('mainCategory')->findOrFail($id);

        return Inertia::render('Settings/Books/Sub/Edit/index', get_defined_vars());

    }

    public function indexEdit($id)
    {
        $mainCategories = BooksMainCategories::get();
        $subCategories = BooksSubCategories::with("mainCategory")->get();
        $book = Books::with('subCategory')->findOrFail($id);
        return Inertia::render('Settings/Books/Edit/index', get_defined_vars());

    }

    public function createMain(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            '*' => "الحقل مطلوب"
        ]);

        $mainCategory = new BooksMainCategories();
        $mainCategory->name = $request->name;
        $mainCategory->save();

        return response()->json([
            "status" => true,
            "item" => $mainCategory
        ]);
    }

    public function createSub(Request $request)
    {
        $request->validate([
            'name' => 'required',
            "mainCategoryId" => 'required',
        ], [
            '*' => "الحقل مطلوب"
        ]);
        $subCategory = new BooksSubCategories();
        $subCategory->name = $request->name;
        $subCategory->main_category_id = $request->mainCategoryId;
        $subCategory->save();

        return response()->json([
            "status" => true,
            "item" => $subCategory
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'author_name' => 'sometimes',
            'sub_category_id' => 'required',
            'file' => 'required|file|mimes:jpeg,png,pdf,docx|max:100240'
        ], [
            '*' => "الحقل مطلوب"
        ]);


        $book = new Books();
        $book->name = $request->name;
        $book->sub_category_id = $request->sub_category_id;
        if ($request->author_name) {
            $book->author_name = $request->author_name;
        }
        if ($request->hasFile('file')) {
            $file = saveImage($request->file('file'), 'uploads/books/');
            $book->file_id = $file;
        }
        $book->save();

        return response()->json([
            "status" => true,
            "item" => $book
        ]);
    }

    public function editMain(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ], [
            '*' => "الحقل مطلوب"
        ]);

        $mainCategory = BooksMainCategories::findOrFail($id);
        $mainCategory->name = $request->name;
        $mainCategory->save();

        return response()->json([
            "status" => true,
            "item" => $mainCategory
        ]);
    }

    public function editSub(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            "mainCategoryId" => 'required',
        ], [
            '*' => "الحقل مطلوب"
        ]);


        $subCategory = BooksSubCategories::findOrFail($id);
        $subCategory->name = $request->name;
        $subCategory->main_category_id = $request->mainCategoryId;

        $subCategory->save();

        return response()->json([
            "status" => true,
            "item" => $subCategory
        ]);
    }
    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'author_name' => 'sometimes',
            'sub_category_id' => 'required',
            'file' => 'sometimes|file|mimes:jpeg,png,pdf,docx|max:100240'
        ], [
            '*' => "الحقل مطلوب"
        ]);


        $book = Books::findOrFail($id);
        $book->name = $request->name;
        $book->sub_category_id = $request->sub_category_id;
        if ($request->author_name) {
            $book->author_name = $request->author_name;
        }
        if ($request->hasFile('file')) {
            $file = saveImage($request->file('file'), 'uploads/books/');
            $book->file_id = $file;
        }
        $book->save();

        return response()->json([
            "status" => true,
            "item" => $book
        ]);
    }

    public function deleteMain($id)
    {
        $item = BooksMainCategories::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
    public function deleteSub($id)
    {
        $item = BooksSubCategories::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
    public function delete($id)
    {
        $item = Books::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
}
