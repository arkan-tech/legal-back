<?php

namespace App\Http\Controllers\Admin\RequestLevel;

use App\Http\Controllers\Controller;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\RequestLevels\RequestLevel;
use App\Models\Service\Service;
use App\Models\Service\ServiceCategory;
use App\Models\Service\ServiceSections;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class RequestLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $services = ClientReservationsImportance::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($services)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-request-levels m-1"  id="btn_delete_request_levels_' . $row->id . '"  href="' . route('admin.request_levels.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_request_levels"  href="' . route('admin.request_levels.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.request_levels.index', get_defined_vars());

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
            'name' => 'required',
        ], [
            'name.required' => 'الحقل مطلوب',
        ]);

        ClientReservationsImportance::create([
            'title' => $request->name,
            'status' => 1,
        ]);

        return response()->json([
            'status' => true,
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
        $item = ClientReservationsImportance::where('status', 1)->findOrFail($id);
        return \response()->json([
            'status' => true,
            'item' => $item,
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
            'name' => 'required',
        ], [
            'name.required' => 'الحقل مطلوب',
        ]);
        $service = ClientReservationsImportance::findOrFail($request->id);
        $service->update([
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
        $item = ClientReservationsImportance::where('status', 1)->findOrFail($id);
        $item->update([
            'status' => 0
        ]);
        return \response()->json([
            'status' => true
        ]);
    }
}
