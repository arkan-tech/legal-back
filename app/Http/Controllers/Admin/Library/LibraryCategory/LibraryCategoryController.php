<?php

namespace App\Http\Controllers\Admin\Library\LibraryCategory;

use App\Http\Controllers\Controller;
use App\Models\Library\LibraryCat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class LibraryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = LibraryCat::orderBy('created_at', 'DESC')->get();
        if ($request->ajax()) {
            return DataTables::of($categories)
                ->addColumn('image', function ($row) {
                    $actions = '<img  src="' . asset('uploads/library/' . $row->image) . '">
                                      <i class="fa fa-trash"></i>
                                  </a>
                               ';
                    return $actions;
                })
                ->addColumn('parent', function ($row) {
                    $type = $row->parent ;

                    if ($type == 0){
                        return 'تصنيف رئيسي';
                    }else{
                        $main = LibraryCat::where('parent', $type)->first();
                        return 'تصنيف فرعي ل : ' .' '. $main->title ;
                    }

                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-library-cat m-1"  id="btn_delete_library_cat_' . $row->id . '"  href="' . route('admin.library.category.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn-replay-client-ymtaz-message"    href="' . route('admin.library.category.edit', $row->id) . '"  data-id="' . $row->id . ' ">
                                      <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'image','parent'])
                ->make(true);
        }
        return view('admin.library.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.library.create');
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
            'main_cat_title' => 'required',
            'main_cat_image' => 'required',
            'main_cat_description' => 'required',
        ], [
            'main_cat_title.required' => 'الحقل مطلوب',
            'main_cat_image.required' => 'الحقل مطلوب'
        ]);
        $main_category = LibraryCat::create([
            'title' => $request->main_cat_title,
            'parent' => 0,
            'description' => $request->main_cat_description,
            'image' => saveImage($request->main_cat_image, 'uploads/library/')
        ]);
        if ($request->has('sub_category')) {
            foreach ($request->sub_category as $sub_category) {
                LibraryCat::create([
                    'title' => $sub_category['title'],
                    'description' => $sub_category['description'],
                    'parent' => $main_category->id,
                    'image' => saveImage($sub_category['image'], 'uploads/library/')
                ]);
            }
        }

        return redirect()->route('admin.library.category.index')->with('success', 'تم اضافة القسم الرئيسي والاقسام الفرعية');
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
        $library_category = LibraryCat::findOrFail($id);
        $library_sub_category = LibraryCat::where('parent', $id)->get();
        return view('admin.library.edit', get_defined_vars());

    }

    public function SubEdit($id)
    {
        $item = LibraryCat::findOrFail($id);
        return \response()->json([
            'status' => true,
            'item' => $item
        ]);

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
            'main_cat_title' => 'required',
            'main_cat_description' => 'required',
        ], [
            'main_cat_title.required' => 'الحقل مطلوب'
        ]);
        $library_category = LibraryCat::findOrFail($request->id);
        $library_category->update([
            'title' => $request->main_cat_title,
            'description' => $request->main_cat_description,
        ]);
        if ($request->has('main_cat_image')) {
            $library_category->update([
                'image' => saveImage($request->main_cat_image, 'uploads/library/')
            ]);
        }
        if ($request->has('sub_category')) {
            foreach ($request->sub_category as $sub_category) {
                if (!is_null($sub_category['title'])) {
                    LibraryCat::create([
                        'title' => $sub_category['title'],
                        'description' => $sub_category['description'],
                        'parent' => $library_category->id,
                        'image' => saveImage($sub_category['image'], 'uploads/library/')
                    ]);
                }

            }
        }
        return redirect()->route('admin.library.category.edit', $request->id)->with('success', 'تم تحديث القسم الرئيسي ');

    }

    public function SubUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => 'الحقل مطلوب'
        ]);
        $library_category = LibraryCat::findOrFail($request->id);
        $library_category->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        if ($request->has('image')) {
            $library_category->update([
                'image' => saveImage($request->image, 'uploads/library/')
            ]);
        }

        return \response()->json([
            'status' => true,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $cate = LibraryCat::findOrFail($id);
        $cate->delete();
        return \response()->json([
            'status' => true
        ]);
    }

    public function SubDestroy($id)
    {
        $cate = LibraryCat::findOrFail($id);
        $cate->delete();
        return \response()->json([
            'status' => true
        ]);
    }
}
