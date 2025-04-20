<?php

namespace App\Http\Controllers\Admin\AdvisoryServices;

use App\Http\Controllers\Controller;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\FunctionalCases\FunctionalCases;
use App\Models\Specialty\AccurateSpecialty;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class AdvisoryServicesImportanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = ClientReservationsImportance::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-advisory-services-importance m-1"  id="btn_delete_advisory_services_importance_' . $row->id . '"  href="' . route('admin.advisory_services_importance.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_advisory_services_importance"  href="' . route('admin.advisory_services_importance.edit', $row->id) . '" data-id="' . $row->id . '" title="عرض ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>
                                  <a class="m-1  btn_show_advisory_services_importance"  href="' . route('admin.advisory_services_importance.show', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-eye"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.advisory_services.importance.index');

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
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);

        $item = ClientReservationsImportance::create([
            'title' => $request->name,
        ]);
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
        $item = ClientReservationsImportance::findOrFail($id);
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
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $item = ClientReservationsImportance::findOrFail($request->id);
        $item->update([
            'title' => $request->name,
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
        $item = ClientReservationsImportance::findOrFail($id);
        $item->update([
            'status' => 0
        ]);
        return \response()->json([
            'status' => true,
        ]);
    }
}
