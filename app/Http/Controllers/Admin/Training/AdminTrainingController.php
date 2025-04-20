<?php

namespace App\Http\Controllers\Admin\Training;

use App\Http\Controllers\Controller;
use App\Models\Courses\Course;
use App\Models\Library\LibraryCat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class AdminTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $items = Course::orderBy('created_at', 'DESC')->get();
        if ($request->ajax()) {
            return DataTables::of($items)
                ->addColumn('price', function ($row) {
                    return $row->price . ' ر.س';
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-training m-1"  id="btn_delete_training_' . $row->id . '"  href="' . route('admin.training.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1"    href="' . route('admin.training.edit', $row->id) . '"  data-id="' . $row->id . ' ">
                                      <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('admin.training.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.training.create');

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
            'image' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب',
            'image.required' => 'الحقل مطلوب',
        ]);
        $item = Course::create(
            $request->except('image')
        );
        $item->update([
            'image' => saveImage($request->image, 'uploads/courses/')
        ]);
        return redirect()->route('admin.training.index')->with('success', 'تم الحفظ بنجاح');
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
        $item = Course::findOrFail($id);
        return view('admin.training.edit', compact('item'));

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
            'image' => 'sometimes'
        ], [
            '*.required' => 'الحقل مطلوب',
            'image.required' => 'الحقل مطلوب',
        ]);
        $item = Course::findOrFail($request->id);

        $item->update(
            $request->except('image')
        );
        if ($request->has('image')) {
            $item->update([
                'image' => saveImage($request->image, 'uploads/courses/')
            ]);
        }

        return redirect()->route('admin.training.index')->with('success', 'تم التحديث بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = Course::findOrFail($id);
        $item->delete();
        return \response()->json(['status' => true]);
    }
}
