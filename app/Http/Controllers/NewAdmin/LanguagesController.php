<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguagesController extends Controller
{
    public function index(Request $request)
    {

        $languages = Language::orderBy('id', 'asc')->get();
        return Inertia::render('Settings/Signup/Languages/index', get_defined_vars());

    }

    public function create()
    {
        return Inertia::render('Settings/Signup/Languages/Create/index', get_defined_vars());

    }
    public function edit($id)
    {
        $language = Language::orderBy('id', 'asc')->findOrFail($id);
        return Inertia::render('Settings/Signup/Languages/Edit/index', get_defined_vars());
    }

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required',

        ], [
            '*.required' => "الحقل مطلوب"
        ]);


        $language = Language::create([
            'name' => $request->name
        ]);
        return response()->json([
            "status" => true,
            "item" => $language
        ]);
    }




    public function update(Request $request)
    {

        $request->validate([
            '*' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $item = Language::findOrFail($request->id);
        $item->update([
            'name' => $request->name
        ]);
        return \response()->json([
            'status' => true,
        ]);

    }

    public function destroy($id)
    {
        $item = Language::findOrFail($id);
        $item->delete();
        return \response()->json([
            'status' => true,
        ]);
    }

}
