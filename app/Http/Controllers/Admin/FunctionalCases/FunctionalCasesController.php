<?php

namespace App\Http\Controllers\Admin\FunctionalCases;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Specialty\AccurateSpecialty;
use App\Models\FunctionalCases\FunctionalCases;

class FunctionalCasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = FunctionalCases::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($items)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-functional-cases m-1"  id="btn_delete_functional_cases_' . $row->id . '"  href="' . route('admin.functional_cases.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_functional_cases"  href="' . route('admin.functional_cases.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted'])
                ->make(true);
        }


        return view('admin.functional_cases.index');

    }

    public function newIndex()
    {
        $functionalCases = FunctionalCases::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Signup/FunctionalCases/index', get_defined_vars());
    }
    public function newEdit($id)
    {
        $functionalCase = FunctionalCases::where('status', 1)->orderBy('created_at', 'desc')->findOrFail($id);
        return Inertia::render('Settings/Signup/FunctionalCases/Edit/index', get_defined_vars());
    }
    public function newCreate()
    {
        return Inertia::render('Settings/Signup/FunctionalCases/Create/index', get_defined_vars());
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
            '*' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);

        $item = FunctionalCases::create([
            'title' => $request->name
        ]);
        return to_route('newAdmin.settings.signup.functional-cases.edit', ['id' => $item->id]);
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
        $item = FunctionalCases::findOrFail($id);
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
            '*' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $item = FunctionalCases::findOrFail($request->id);
        $item->update([
            'title' => $request->name

        ]);
        return to_route('newAdmin.settings.signup.functional-cases.edit', ['id' => $item->id]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = FunctionalCases::findOrFail($id);
        $item->update([
            'status' => 0
        ]);

        return to_route('newAdmin.settings.signup.functional-cases.index');
    }
}
