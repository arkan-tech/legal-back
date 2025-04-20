<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\Rank;
use Inertia\Inertia;
use App\Models\Books;
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


class RanksController extends Controller
{
    public function index()
    {
        $ranks = Rank::get();
        return Inertia::render('Settings/Gamification/Ranks/index', get_defined_vars());
    }

    public function indexCreate()
    {
        return Inertia::render('Settings/Gamification/Ranks/Create/index', get_defined_vars());
    }


    public function indexEdit($id)
    {

        $rank = Rank::findOrFail($id);
        return Inertia::render('Settings/Gamification/Ranks/Edit/index', get_defined_vars());

    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'min_level' => 'required',
            'border_color' => 'required',
            'image' => 'required'
        ], [
            '*' => "الحقل مطلوب"
        ]);


        $rank = Rank::create([
            "name" => $request->name,
            "min_level" => $request->min_level,
            "border_color" => $request->border_color,
            'image' => saveImage($request->file('image'), 'uploads/ranks/')
        ]);

        return response()->json([
            "status" => true,
            "item" => $rank
        ]);
    }


    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'min_level' => 'required',
            'border_color' => 'required',
            'image' => 'required'
        ], [
            '*' => "الحقل مطلوب"
        ]);

        $rank = Rank::findOrFail($id);
        $rank->update([
            "name" => $request->name,
            "min_level" => $request->min_level,
            "border_color" => $request->border_color,
        ]);
        if ($request->hasFile('image')) {
            $rank->update([

                'image' => saveImage($request->file('image'), 'uploads/ranks/')
            ]);
        }

        return response()->json([
            "status" => true,
            "item" => $rank
        ]);
    }


    public function delete($id)
    {
        $item = Rank::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
}
