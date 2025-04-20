<?php

namespace App\Http\Controllers\Admin\Settings\Citites;

use Inertia\Inertia;
use App\Models\City\City;
use Illuminate\Http\Request;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countries = City::where('status', 1)->with('country', 'region')->orderBy('created_at', 'desc')->get();
            return DataTables::of($countries)
                ->addColumn('region', function ($row) {
                    return $row->region->name;
                })
                ->addColumn('country', function ($row) {
                    return $row->country->name;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-cities m-1"  id="btn_delete_cities_' . $row->id . '"  href="' . route('admin.cities.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_cities"  href="' . route('admin.cities.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $countries = Country::where('status', 1)->get();
        $regions = Regions::where('status', 1)->get();
        return view('admin.settings.cities.index', get_defined_vars());

    }

    public function newIndex()
    {
        $cities = City::where('status', 1)->with('country', 'region')->orderBy('created_at', 'desc')->get();
        $regions = Regions::where('status', 1)->orderBy('created_at', 'desc')->get();
        $countries = Country::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Signup/Cities/index', get_defined_vars());

    }
    public function newEdit($id)
    {
        $city = City::where('status', 1)->with('country', 'region')->orderBy('created_at', 'desc')->findOrFail($id);
        $regions = Regions::where('status', 1)->orderBy('created_at', 'desc')->get();
        $countries = Country::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Signup/Cities/Edit/index', get_defined_vars());

    }

    public function newCreate()
    {
        $countries = Country::where('status', 1)->orderBy('created_at', 'desc')->get();
        $regions = Regions::where('status', 1)->orderBy('created_at', 'desc')->get();

        return Inertia::render('Settings/Signup/Cities/Create/index', get_defined_vars());
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            '*' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $item = City::create([
            'title' => $request->name,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
        ]);
        return to_route('newAdmin.settings.signup.cities.edit', ['id' => $item->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::findOrFail($id);
        return \response()->json([
            'status' => true,
            'city' => $city
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            '*' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $city = City::findOrFail($request->id);
        $city->update([
            'title' => $request->name,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
        ]);
        return \response()->json([
            'status' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->status = 0;
        $city->update();

        return to_route('newADmin.settings.signup.cities.index');
    }
}
