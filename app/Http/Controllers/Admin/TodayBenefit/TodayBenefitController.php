<?php

namespace App\Http\Controllers\Admin\TodayBenefit;

use App\Http\Controllers\Controller;
use App\Models\TodayBenefit\TodayBenefit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class TodayBenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = TodayBenefit::orderBy('created_at','desc')->get();
            return DataTables::of($items)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-benefit m-1"  id="btn_delete_benefit_' . $row->id . '"  href="' . route('admin.benefit.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_benefit"  href="' . route('admin.benefit.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted'])
                ->make(true);
        }
        return view('admin.today_benefit.index');
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
           'title' =>'required',
           'image' =>'required',
        ],[
            'title.required' =>'يجب اضافة نص قصير ',
            'image.required' =>'يجب اضافة صورة ',
        ]);
        TodayBenefit::create([
           'text'=>$request->title,
           'image'=>saveImage($request->image,'uploads/api/today_benefit/' ) ,
        ]);
    return \response()->json([
       'status'=>true
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
        $item = TodayBenefit::findOrFail($id);
        return  \response()->json([
           'status'=>true,
           'item'=>$item
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
            'title' =>'required',
            'image' =>'sometimes',
        ],[
            'title.required' =>'يجب اضافة نص قصير ',
        ]);
        $item = TodayBenefit::findOrFail($request->id);
        $item->update([
            'text'=>$request->title,
        ]);

        if ($request->has('image')){
            $item->update([
                'image'=>saveImage($request->image,'uploads/api/today_benefit/' ) ,
            ]);
        }
        return  \response()->json([
            'status'=>true,
            'item'=>$item
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
        $item = TodayBenefit::findOrFail($id);

        $item->delete();
        return  \response()->json([
            'status'=>true,
        ]);

    }
}
