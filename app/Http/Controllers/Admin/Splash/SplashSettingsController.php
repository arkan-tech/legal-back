<?php

namespace App\Http\Controllers\Admin\Splash;

use App\Http\Controllers\Controller;
use App\Models\API\Splash\Splash;
use App\Models\FunctionalCases\FunctionalCases;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class SplashSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = Splash::where('status', 1)->get();
            return DataTables::of($items)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-splash m-1"  id="btn_delete_splash_' . $row->id . '"  href="' . route('admin.splash.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_splash"  href="' . route('admin.splash.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted'])
                ->make(true);
        }
        return view('admin.splash.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
            'image' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب',
            'image.required' => 'الحقل مطلوب',
        ]);
        $item = Splash::create([
            'description' => $request->title,
            'status' => 1,
        ]);
        if ($request->has('image')) {
            $item->update([
                'image' => saveImage($request->image, 'uploads/api/splash/'),
            ]);
        }
        return \response()->json([
            'status' => true
        ]);
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
        $item = Splash::findOrFail($id);
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
            '*' => 'required',
            'image' => 'sometimes',
        ], [
            '*.required' => 'الحقل مطلوب',
            'image.required' => 'الحقل مطلوب',
        ]);
        $item = Splash::findOrFail($request->id);
        $item->update([
            'description' => $request->title,
            'status' => 1,
        ]);
        if ($request->has('image')) {
            $item->update([
                'image' => saveImage($request->image, 'uploads/api/splash/'),
            ]);
        }
        return \response()->json([
            'status' => true
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
        $item = Splash::findOrFail($id);
        $item->update([
            'status' => 0
        ]);

        return \response()->json([
            'status' => true,
        ]);
    }
}
