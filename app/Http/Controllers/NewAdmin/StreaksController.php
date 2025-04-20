<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\Degree\Degree;
use App\Models\StreakMilestone;
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


class StreaksController extends Controller
{
    public function index()
    {
        $streaks = StreakMilestone::get();
        return Inertia::render('Settings/Gamification/Streaks/index', get_defined_vars());
    }

    public function indexCreate()
    {
        return Inertia::render('Settings/Gamification/Streaks/Create/index', get_defined_vars());

    }


    public function indexEdit($id)
    {

        $streak = StreakMilestone::findOrFail($id);
        return Inertia::render('Settings/Gamification/Streaks/Edit/index', get_defined_vars());

    }

    public function create(Request $request)
    {
        $request->validate([
            'streak_milestone' => 'required',
            'milestone_xp' => 'required',
        ], [
            '*' => "الحقل مطلوب"
        ]);


        $streakMilestone = StreakMilestone::create([
            "streak_milestone" => $request->streak_milestone,
            "milestone_xp" => $request->milestone_xp,
        ]);

        return response()->json([
            "status" => true,
            "item" => $streakMilestone
        ]);
    }


    public function edit(Request $request, $id)
    {
        $request->validate([
            'streak_milestone' => 'required',
            'milestone_xp' => 'required',
        ], [
            '*' => "الحقل مطلوب"
        ]);

        $streakMilestone = StreakMilestone::findOrFail($id);
        $streakMilestone->update([
            "streak_milestone" => $request->streak_milestone,
            "milestone_xp" => $request->milestone_xp,
        ]);

        return response()->json([
            "status" => true,
            "item" => $streakMilestone
        ]);
    }


    public function delete($id)
    {
        $item = StreakMilestone::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
}
