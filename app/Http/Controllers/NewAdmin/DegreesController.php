<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\Degree\Degree;
use Inertia\Inertia;
use App\Models\Books;
use App\Models\City\City;
use Illuminate\Http\Request;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Models\BooksSubCategories;
use App\Models\BooksMainCategories;
use App\Http\Controllers\Controller;
use App\Rules\ArrayAtLeastOneRequired;
use Google\Service\AndroidEnterprise\GoogleAuthenticationSettings;


class DegreesController extends Controller
{
    public function index()
    {
        $degrees = Degree::where('isYmtaz', 1)->get();
        return Inertia::render('Settings/Signup/Degrees/index', get_defined_vars());
    }

    public function indexCreate()
    {
        return Inertia::render('Settings/Signup/Degrees/Create/index', get_defined_vars());

    }


    public function indexEdit($id)
    {

        $degree = Degree::where('isYmtaz', 1)->findOrFail($id);
        return Inertia::render('Settings/Signup/Degrees/Edit/index', get_defined_vars());

    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'isSpecial' => 'required',
        ], [
            '*' => "الحقل مطلوب"
        ]);


        $degree = Degree::where('isYmtaz', 1)->create([
            "title" => $request->name,
            "isSpecial" => $request->isSpecial,
            "isYmtaz" => 1
        ]);

        return response()->json([
            "status" => true,
            "item" => $degree
        ]);
    }


    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'isSpecial' => 'required',

        ], [
            '*' => "الحقل مطلوب"
        ]);

        $degree = Degree::where('isYmtaz', 1)->findOrFail($id);
        $degree->update([
            "title" => $request->name,
            "isSpecial" => $request->isSpecial,
        ]);

        return response()->json([
            "status" => true,
            "item" => $degree
        ]);
    }


    public function delete($id)
    {
        $item = Degree::where('isYmtaz', 1)->findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
}
