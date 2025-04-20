<?php

namespace App\Http\Controllers\Admin\AdvisoryServices;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Specialty\AccurateSpecialty;
use App\Models\FunctionalCases\FunctionalCases;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesBase;

class AdvisoryServicesBaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = AdvisoryServicesBase::orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-advisory-services-base m-1"  id="btn_delete_advisory_services_base_' . $row->id . '"  href="' . route('admin.advisory_services_base.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_advisory_services_base"  href="' . route('admin.advisory_services_base.edit', $row->id) . '" data-id="' . $row->id . '" title="عرض ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>
                                  <a class="m-1  btn_show_advisory_services_base"  href="' . route('admin.advisory_services_base.show', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-eye"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.advisory_services.base.index');

    }

    public function newIndex(Request $request)
    {
        $advisoryServicesBase = AdvisoryServicesBase::orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/AdvisoryServices/Base/index', get_defined_vars());
    }
    public function newEdit($id)
    {
        $base = AdvisoryServicesBase::orderBy('created_at', 'desc')->findOrFail($id);
        return Inertia::render('Settings/AdvisoryServices/Base/Edit/index', get_defined_vars());
    }
    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return Inertia::render('Settings/AdvisoryServices/Base/Create/index');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {

        $request->validate([
            '*' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);

        $item = AdvisoryServicesBase::create([
            'title' => $request->name,
        ]);
        return to_route('newAdmin.settings.advisory_services.base.edit', ["id" => $item->id]);
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
        $item = AdvisoryServicesBase::findOrFail($id);
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
        $item = AdvisoryServicesBase::findOrFail($request->id);
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
     */
    public function destroy($id)
    {
        $item = AdvisoryServicesBase::findOrFail($id);
        $item->delete();
        return to_route('newAdmin.settings.advisory_services.base.index');
    }
}
