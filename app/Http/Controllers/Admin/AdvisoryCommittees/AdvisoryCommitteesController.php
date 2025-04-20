<?php

namespace App\Http\Controllers\Admin\AdvisoryCommittees;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;

class AdvisoryCommitteesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = AdvisoryCommittee::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-advisory-committees m-1"  id="btn_delete_advisory_committees_' . $row->id . '"  href="' . route('admin.advisory-committees.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn-edit-advisory-committees"    href="' . route('admin.advisory-committees.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted'])
                ->make(true);

        }
        return view('admin.advisory_committees.index');
    }

    public function newIndex()
    {
        $advisoryCommittees = AdvisoryCommittee::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Advisory-Committees/index', get_defined_vars());
    }
    public function newCreate()
    {
        return Inertia::render('Advisory-Committees/Create/index', get_defined_vars());
    }
    public function newEdit($id)
    {
        $advisoryCommittee = AdvisoryCommittee::where('status', 1)->orderBy('created_at', 'desc')->findOrFail($id);
        $success = session('success', false);
        return Inertia::render('Advisory-Committees/Edit/index', get_defined_vars());
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
     */
    public function store(Request $request)
    {
        $request->validate([
            '*' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب',
        ]);

        $newAd = AdvisoryCommittee::create([
            'title' => $request->name,
            'status' => 1,
        ]);
        return to_route('newAdmin.advisory-committees.edit', ["id" => $newAd->id])->with("success", "تم انشاء الملف بنجاح");
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
        $item = AdvisoryCommittee::findOrFail($id);
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
            'name' => 'required',
        ], [
            'name.required' => 'الحقل مطلوب'
        ]);
        $item = AdvisoryCommittee::findOrFail($request->id);
        $item->update([
            'title' => $request->name
        ]);

        return \response()->json(['status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = AdvisoryCommittee::findOrFail($id);
        $item->update([
            'status' => 0
        ]);
        return to_route("newAdmin.advisory-committees.index");
    }
}
