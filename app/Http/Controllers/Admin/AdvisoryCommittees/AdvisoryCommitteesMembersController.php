<?php

namespace App\Http\Controllers\Admin\AdvisoryCommittees;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Lawyer\LawyersAdvisorys;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;

class AdvisoryCommitteesMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = Lawyer::where('is_advisor', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->addColumn('name', function ($row) {
                    $actions = '<a   href="' . route('admin.digital-guide.editById', $row->id) . '" target="_blank">
                                      ' . $row->name . '
                                  </a>';
                    return $actions;
                })
                ->addColumn('accepted', function ($row) {
                    $status = $row->accepted;
                    switch ($status) {
                        case 1:
                            return '<div class="  bg-primary text-white">جديد</div>';
                            break;
                        case 2:
                            return '<div class="  bg-success  text-white">مقبول</div>';
                            break;
                        case 3:
                            return '<div class=" bg-warning  text-white">انتظار</div>';
                            break;
                        case 0:
                            return '<div class=" bg-danger  text-white">محظور</div>';
                            break;
                    }

                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-advisory-committees-member m-1"  id="btn_delete_advisory_committees_member_' . $row->id . '"  href="' . route('admin.advisory-committees.members.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn-edit-advisory-committees-member"    href="' . route('admin.advisory-committees.members.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted', 'name'])
                ->make(true);

        }
        $advisors = AdvisoryCommittee::where('status', 1)->get();
        return view('admin.advisory_committees.members.index', get_defined_vars());
    }
    public function newIndex()
    {
        $advisoryCommitteesLawyers = Lawyer::where('is_advisor', 1)->select(
            'lawyers.*',
            \DB::raw('CASE
                                WHEN accepted = 1 THEN "جديد"
                                WHEN accepted = 2 THEN "مقبول"
                                WHEN accepted = 3 THEN "انتظار"
                                WHEN accepted = 0 THEN "محظور"
                                ELSE "" END as accepted_text'),
        )->orderBy('created_at', 'desc')->get();
        return Inertia::render('Advisory-Committees/Lawyers/index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public
        function create(
    ) {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public
        function store(
        Request $request
    ) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public
        function show(
        $id
    ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public
        function edit(
        $id
    ) {
        $item = Lawyer::findOrFail($id);
        $lawyer_advisories = LawyersAdvisorys::where('lawyer_id', $item->id)->pluck('advisory_id')->toArray();

        return \response()->json(['status' => true, 'item' => $item, 'lawyer_advisories' => $lawyer_advisories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public
        function update(
        Request $request
    ) {
        $request->validate([
            '*' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $lawyer = Lawyer::findOrFail($request->id);

        $items = LawyersAdvisorys::where('lawyer_id', $lawyer->id)->get();
        foreach ($items as $item) {
            $item->delete();
        }
        foreach ($request->advisor as $cat) {
            LawyersAdvisorys::create([
                'lawyer_id' => $lawyer->id,
                'advisory_id' => $cat,
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public
        function destroy(
        $id
    ) {
        $lawyer = Lawyer::findOrFail($id);
        $lawyer->update([
            'is_advisor' => 0,
        ]);
        $items = LawyersAdvisorys::where('lawyer_id', $lawyer->id)->get();
        foreach ($items as $item) {
            $item->delete();
        }
        return \response()->json(['status' => true]);
    }
}
