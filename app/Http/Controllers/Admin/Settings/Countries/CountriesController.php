<?php

namespace App\Http\Controllers\Admin\Settings\Countries;

use Inertia\Inertia;
use App\Models\City\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Country\Country;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countries = Country::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($countries)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-country m-1"  id="btn_delete_country_' . $row->id . '"  href="' . route('admin.countries.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_country"  href="' . route('admin.countries.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted'])
                ->make(true);
        }


        return view('admin.settings.countries.index');

    }

    public function newIndex()
    {
        $countries = Country::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Signup/Countries/index', get_defined_vars());

    }
    public function newEdit($id)
    {
        $country = Country::where('status', 1)->orderBy('created_at', 'desc')->findOrFail($id);
        return Inertia::render('Settings/Signup/Countries/Edit/index', get_defined_vars());

    }

    public function newCreate()
    {
        return Inertia::render('Settings/Signup/Countries/Create/index');
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
            'phone_code' => 'required',
        ], [
            'name.required' => 'الحقل مطلوب',
            'phone_code.required' => 'الحقل مطلوب',
        ]);
        $country = Country::create([
            'name' => $request->name,
            'phone_code' => $request->phone_code,
            'status' => 1,
        ]);
        return to_route('newAdmin.settings.signup.countries.edit', ['id' => $country->id]);
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
        $country = Country::findOrFail($id);
        return \response()->json([
            'status' => true,
            'country' => $country
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
            'phone_code' => 'required',
        ], [
            'name.required' => 'الحقل مطلوب',
            'phone_code.required' => 'الحقل مطلوب',
        ]);
        $country = Country::findOrFail($request->id);
        $country->update([
            'name' => $request->name,
            'phone_code' => $request->phone_code,
        ]);
        return \response()->json([
            'status' => true,
            'country' => $country
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {

        $country = Country::findOrFail($id);
        $country->status = 0;
        $country->update();
        return to_route('newAdmin.settings.signup.countries.index');

    }
}
