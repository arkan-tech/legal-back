<?php

namespace App\Http\Controllers\Admin\Complaints;

use App\Http\Controllers\Controller;
use App\Models\Complaint\Complaint;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = Complaint::with('client','lawyer')->orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->addColumn('client_name',function ($row){
                    return $row->client->myname;
                })
                ->addColumn('lawyer_name',function ($row){
                    return $row->lawyer->name;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-complaint m-1"  id="btn_delete_complaint_' . $row->id . '"  href="' . route('admin.complains.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_show_complaint"  href="' . route('admin.complains.show', $row->id) . '" data-id="' . $row->id . '" title="عرض ">
                                     <i class="fa-solid fa-eye"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted'])
                ->make(true);
        }


        return view('admin.complaint.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Complaint::with('client','lawyer')->findOrFail($id);
        return  response()->json([
           'status'=>true,
           'item'=>$item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Complaint::with('client','lawyer')->findOrFail($id);
        $item ->delete();
        return  response()->json([
            'status'=>true,
        ]);
    }
}
