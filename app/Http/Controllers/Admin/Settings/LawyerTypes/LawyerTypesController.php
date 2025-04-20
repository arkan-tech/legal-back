<?php

namespace App\Http\Controllers\Admin\Settings\LawyerTypes;

use App\Http\Controllers\Controller;
use App\Models\Lawyer\LawyerType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class LawyerTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countries = LawyerType::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($countries)
                ->editColumn('need_company_name', function ($row) {
                    $need_company_name = $row->need_company_name;
                    if ($need_company_name == 1) {
                        return 'مطلوب';
                    } else {
                        return 'غير مطلوب';

                    }
                })
                ->editColumn('need_company_licence_file', function ($row) {
                    $need_company_licence_file = $row->need_company_licence_file;
                    if ($need_company_licence_file == 1) {
                        return 'مطلوب';
                    } else {
                        return 'غير مطلوب';

                    }
                })
                ->editColumn('need_company_licence_no', function ($row) {
                    $need_company_licence_no = $row->need_company_licence_no;
                    if ($need_company_licence_no == 1) {
                        return 'مطلوب';
                    } else {
                        return 'غير مطلوب';

                    }
                })
                ->addColumn('action', function ($row) {
                    $actions = ' <a class="m-1 btn_edit_lawyer_types"  href="' . route('admin.lawyer_types.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('admin.settings.lawyer_types.index');

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
        //
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
        $item = LawyerType::findOrFail($id);
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
            'type_name' => 'required',
        ], [
            'type_name.required' => 'الحقل مطلوب'
        ]);
        $item = LawyerType::findOrFail($request->id);
        $item->update([
            'type_name' => $request->type_name,
            'need_company_licence_no' => $request->need_company_licence_no,
            'need_company_licence_file' => $request->need_company_licence_file,
            'need_company_name' => $request->need_company_name,
        ]);
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
        //
    }
}
