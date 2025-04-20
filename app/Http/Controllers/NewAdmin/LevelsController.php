<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use App\Models\Books;
use App\Models\Level;
use App\Models\City\City;
use Illuminate\Http\Request;
use App\Models\Degree\Degree;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Models\BooksSubCategories;
use App\Models\BooksMainCategories;
use App\Http\Controllers\Controller;
use App\Rules\ArrayAtLeastOneRequired;
use Google\Service\AndroidEnterprise\GoogleAuthenticationSettings;


class LevelsController extends Controller
{
    public function index()
    {
        $levels = Level::get();
        return Inertia::render('Settings/Gamification/Levels/index', get_defined_vars());
    }

    public function indexCreate()
    {
        $levels = Level::get();
        return Inertia::render('Settings/Gamification/Levels/Create/index', get_defined_vars());

    }


    public function indexEdit($id)
    {

        $level = Level::findOrFail($id);
        return Inertia::render('Settings/Gamification/Levels/Edit/index', get_defined_vars());

    }

    public function create(Request $request)
    {
        $request->validate([
            'level_number' => 'required',
            'required_experience' => 'required',
        ], [
            '*' => "الحقل مطلوب"
        ]);


        $level = Level::create([
            "level_number" => $request->level_number,
            "required_experience" => $request->required_experience,
        ]);

        return response()->json([
            "status" => true,
            "item" => $level
        ]);
    }


    public function edit(Request $request, $id)
    {
        $request->validate([
            'level_number' => 'required',
            'required_experience' => 'required',

        ], [
            '*' => "الحقل مطلوب"
        ]);

        $level = Level::findOrFail($id);
        $level->update([
            "level_number" => $request->level_number,
            "required_experience" => $request->required_experience,
        ]);

        return response()->json([
            "status" => true,
            "item" => $level
        ]);
    }


    public function delete($id)
    {
        $item = Level::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
}
