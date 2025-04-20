<?php

namespace App\Http\Controllers\Admin\Specialty;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Specialty\AccurateSpecialty;

class AccurateSpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = AccurateSpecialty::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-accurate-specialty m-1"  id="btn_delete_accurate_specialty_' . $row->id . '"  href="' . route('admin.accurate_specialty.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_accurate_specialty"  href="' . route('admin.accurate_specialty.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted'])
                ->make(true);
        }


        return view('admin.specialty.accurate_specialty.index');

    }

    public function newIndex()
    {
        $accurateSpecialties = AccurateSpecialty::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Signup/AccurateSpecialty/index', get_defined_vars());
    }
    public function newEdit($id)
    {
        $accurateSpecialty = AccurateSpecialty::where('status', 1)->orderBy('created_at', 'desc')->findOrFail($id);
        return Inertia::render('Settings/Signup/AccurateSpecialty/Edit/index', get_defined_vars());
    }
    public function newCreate()
    {
        return Inertia::render('Settings/Signup/AccurateSpecialty/Create/index', get_defined_vars());
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
            '*' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);

        $item = AccurateSpecialty::create([
            'title' => $request->name
        ]);
        return to_route('newAdmin.settings.signup.general-specialty.edit', ['id' => $item->id]);
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
        $item = AccurateSpecialty::findOrFail($id);
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
     */
    public function update(Request $request)
    {
        $request->validate([
            '*' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $item = AccurateSpecialty::findOrFail($request->id);
        $item->update([
            'title' => $request->name

        ]);
        return to_route('newAdmin.settings.signup.accurate-specialty.edit', ['id' => $item->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $item = AccurateSpecialty::findOrFail($id);
        $item->update([
            'status' => 0
        ]);

        return to_route('newAdmin.settings.signup.accurate-specialty.index');
    }
}
