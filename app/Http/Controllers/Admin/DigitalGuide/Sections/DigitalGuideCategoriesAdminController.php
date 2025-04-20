<?php

namespace App\Http\Controllers\Admin\DigitalGuide\Sections;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\DigitalGuide\DigitalGuideCategories;

class DigitalGuideCategoriesAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = DigitalGuideCategories::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->addColumn('need_license', function ($row) {
                    $need_license = $row->need_license == 1 ? 'تحتاج ترخيص' : 'لا تحتاج ترخيص';
                    return $need_license;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-section m-1"  id="btn_delete_section_' . $row->id . '"  href="' . route('admin.digital-guide.sections.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_section"  href="' . route('admin.digital-guide.sections.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.digital_guide.sections.index', get_defined_vars());

    }

    public function newIndex()
    {
        $jobs = DigitalGuideCategories::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Signup/Jobs/index', get_defined_vars());

    }
    public function newEdit($id)
    {
        $job = DigitalGuideCategories::where('status', 1)->orderBy('created_at', 'desc')->findOrFail($id);
        return Inertia::render('Settings/Signup/Jobs/Edit/index', get_defined_vars());

    }

    public function newCreate()
    {
        return Inertia::render('Settings/Signup/Jobs/Create/index');
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
        $section = DigitalGuideCategories::create([
            'title' => $request->name,
            'need_license' => $request->need_license,
            'status' => 1,
        ]);


        return to_route('newAdmin.settings.signup.jobs.edit', ["id" => $section->id]);
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
        $section = DigitalGuideCategories::findOrFail($id);
        return \response()->json([
            'status' => true,
            'section' => $section
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
            '*.required' => 'الحقل مطلوب',
        ]);
        $section = DigitalGuideCategories::findORFail($request->id);
        $section->update([
            'title' => $request->name,
            'need_license' => $request->need_license,
        ]);


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
        $section = DigitalGuideCategories::findOrFail($id);
        $section->delete();
        return to_route('newAdmin.settings.signup.jobs.index');
    }
}
