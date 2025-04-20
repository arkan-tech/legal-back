<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\Activity;
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


class ActivitiesController extends Controller
{
    public function index()
    {
        $activities = Activity::get();
        return Inertia::render('Settings/Gamification/Activities/index', get_defined_vars());
    }

    public function indexCreate()
    {
        return Inertia::render('Settings/Gamification/Activities/Create/index', get_defined_vars());

    }


    public function indexEdit($id)
    {

        $activity = Activity::findOrFail($id);
        return Inertia::render('Settings/Gamification/Activities/Edit/index', get_defined_vars());

    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'experience_points' => 'required',
        ], [
            '*' => "الحقل مطلوب"
        ]);


        $activity = Activity::create([
            "name" => $request->name,
            "experience_points" => $request->experience_points,
        ]);

        return response()->json([
            "status" => true,
            "item" => $activity
        ]);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'experience_points' => 'required',
            'notification' => 'required'

        ], [
            '*' => "الحقل مطلوب"
        ]);

        $activity = Activity::findOrFail($id);
        $activity->update([
            "name" => $request->name,
            "experience_points" => $request->experience_points,
            'notification' => $request->notification
        ]);

        return response()->json([
            "status" => true,
            "item" => $activity
        ]);
    }


    public function delete($id)
    {
        $item = Activity::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
}
