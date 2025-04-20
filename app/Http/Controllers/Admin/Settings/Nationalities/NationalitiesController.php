<?php

namespace App\Http\Controllers\Admin\Settings\Nationalities;

use Inertia\Inertia;
use App\Models\City\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Country\Country;
use Yajra\DataTables\DataTables;
use App\Models\Country\Nationality;
use App\Http\Controllers\Controller;

class NationalitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countries = Nationality::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($countries)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-nationalities m-1"  id="btn_delete_nationalities_' . $row->id . '"  href="' . route('admin.nationalities.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_nationalities"  href="' . route('admin.nationalities.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted'])
                ->make(true);
        }


        return view('admin.settings.nationalities.index');

    }


    public function newIndex()
    {
        $nationalities = Nationality::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Signup/Nationalities/index', get_defined_vars());

    }
    public function newEdit($id)
    {
        $nationality = Nationality::where('status', 1)->orderBy('created_at', 'desc')->findOrFail($id);
        return Inertia::render('Settings/Signup/Nationalities/Edit/index', get_defined_vars());

    }

    public function newCreate()
    {
        return Inertia::render('Settings/Signup/Nationalities/Create/index');
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
            'name' => 'required',
        ], [
            'name.required' => 'الحقل مطلوب',
        ]);
        $country = Nationality::create([
            'name' => $request->name,
            'status' => 1,
        ]);
        return to_route('newAdmin.settings.signup.nationalities.edit', ['id' => $country->id]);
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
        $item = Nationality::findOrFail($id);
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
            'name.required' => 'الحقل مطلوب',
        ]);
        $country = Nationality::findOrFail($request->id);
        $country->update([
            'name' => $request->name,
        ]);
        return \response()->json([
            'status' => true,
            'item' => $country
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

        $country = Nationality::findOrFail($id);
        $country->status = 0;
        $country->update();
        return to_route('newAdmin.settings.signup.nationalities.index');

    }
}
