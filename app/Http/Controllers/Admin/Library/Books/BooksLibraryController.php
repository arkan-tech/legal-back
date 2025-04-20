<?php

namespace App\Http\Controllers\Admin\Library\Books;

use App\Http\Controllers\Controller;
use App\Models\Library\Books\Book;
use App\Models\Library\LibraryCat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class BooksLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $books = Book::with('cat')->OrderBy('created_at', 'DESC')->get();
            return DataTables::of($books)
//                ->addColumn('cat', function ($row) {
//                    $cat = $row->cat->title;
//                    return $cat;
//                })
                ->addColumn('image', function ($row) {
                    $image = '<img  src="' . $row->image . '">';
                    return $image;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-book m-1"  id="btn_delete_book_' . $row->id . '"  href="' . route('admin.library.books.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn-replay-client-ymtaz-message"    href="' . route('admin.library.books.edit', $row->id) . '"  data-id="' . $row->id . ' ">
                                      <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);

        }
        return view('admin.library.books.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $main_cat = LibraryCat::where('parent', '0')->get();
        $sub_cat = [];
        return view('admin.library.books.create', get_defined_vars());

    }

    public function getLibrarySubCatBaseId($id)
    {
        $sub_cat = LibraryCat::where('parent', $id)->get();
        $items_html = view('admin.library.books.includes.sub-cat-select', compact('sub_cat'))->render();
        return \response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'Image' => 'required',
            'Link' => 'required',
            'link_en' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب',
            'Image.required' => 'الحقل مطلوب',
            'Link.required' => 'الحقل مطلوب',
            'link_en.required' => 'الحقل مطلوب',
        ]);
        Book::create([
            'Title' => $request->Title,
            'CatID' => $request->sub_cat,
            'details' => $request->details,
            'price' => $request->price,
            'author' => $request->author,
            'Image' => saveImage($request->Image, 'uploads/books/'),
            'Link' => saveImage($request->Link, 'uploads/books/'),
            'link_en' => saveImage($request->link_en, 'uploads/books/'),
        ]);
        return redirect()->route('admin.library.books.index')->with('success', 'تم اضافة الكتاب بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $cat = LibraryCat::where('id', $book->CatID)->first();
        $m_cat = LibraryCat::where('id', $cat->parent)->first();
        $main_cat = LibraryCat::where('parent', '0')->get();
        $sub_cat = LibraryCat::where('parent', $m_cat->id)->get();
        return view('admin.library.books.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'Image' => 'sometimes',
            'Link' => 'sometimes',
            'details' => 'sometimes',
        ], [
            '*.required' => 'الحقل مطلوب',
        ]);
        $book = Book::FindOrFail($request->id);
        $book->update([
            'Title' => $request->Title,
            'CatID' => $request->sub_cat,
            'details' => $request->details,
            'price' => $request->price,
            'author' => $request->author,

        ]);
        if ($request->has('Image')) {
            $book->update([
                'Image' => saveImage($request->Image, 'uploads/books/'),

            ]);
        }
        if ($request->has('Link')) {
            $book->update([
                'Link' => saveImage($request->Link, 'uploads/books/'),
            ]);
        }

        if ($request->has('link_en')) {
            $book->update([
                'link_en' => saveImage($request->link_en, 'uploads/books/'),
            ]);
        }

        return redirect()->route('admin.library.books.edit', $book->id)->with('success', 'تم تخديث الكتاب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return \response()->json([
            'status' => true
        ]);
    }
}
