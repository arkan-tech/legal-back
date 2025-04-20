<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClientReservations\ClientReservationsImportance;


class DashboardUserSettings extends Controller
{

    public function index()
    {
        $users = User::withTrashed()->with('roles')->get();
        return Inertia::render("Settings/Dashboard/Users/index", get_defined_vars());
    }
    public function edit($id)
    {
        $users = User::withTrashed()->with('roles')->findOrFail($id);
        return Inertia::render("Settings/Dashboard/Users/Edit/index", get_defined_vars());
    }

    public function createForm()
    {
        return Inertia::render("Settings/Dashboard/Users/Create/index");
    }

    public function create(Request $request)
    {
        // $request->validate([
        //     "title" => "required",
        // ], [
        //     "*" => "الحقل مطلوب"
        // ]);
        // $importance = ClientReservationsImportance::create($request->all());
        // return response()->json([
        //     "status" => true
        // ]);
    }
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     "title" => "required",
        // ], [
        //     "*" => "الحقل مطلوب"
        // ]);

        // ClientReservationsImportance::findOrFail($id)->update($request->all());
        // return response()->json([
        //     "status" => true
        // ]);
    }
}
