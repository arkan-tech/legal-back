<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClientReservations\ClientReservationsImportance;


class ImportanceSettingsController extends Controller
{

    public function index()
    {
        $importances = ClientReservationsImportance::get();
        return Inertia::render("Settings/Importance/index", get_defined_vars());
    }
    public function edit($id)
    {
        $importance = ClientReservationsImportance::findOrFail($id);
        return Inertia::render("Settings/Importance/Edit/index", get_defined_vars());
    }

    public function createForm()
    {
        return Inertia::render("Settings/Importance/Create/index");
    }

    public function create(Request $request)
    {
        $request->validate([
            "title" => "required",
        ], [
            "*" => "الحقل مطلوب"
        ]);
        $importance = ClientReservationsImportance::create($request->all());
        return response()->json([
            "status" => true
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            "title" => "required",
        ], [
            "*" => "الحقل مطلوب"
        ]);

        ClientReservationsImportance::findOrFail($id)->update($request->all());
        return response()->json([
            "status" => true
        ]);
    }

    public function delete($id)
    {
        ClientReservationsImportance::findOrFail($id)->delete();
        return response()->json([
            "status" => true
        ]);

    }
}
