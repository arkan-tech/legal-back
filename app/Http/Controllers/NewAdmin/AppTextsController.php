<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\Activity;
use App\Models\AppTexts;
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


class AppTextsController extends Controller
{
    public function index()
    {
        $appTexts = AppTexts::get();
        return Inertia::render('Settings/AppTexts/index', get_defined_vars());
    }


    public function update(Request $request)
    {
        $request->validate([
            "data" => "required|array",
            "data.*.key" => "required|string",
            "data.*.value" => "required|string",

        ], [
            '*' => "الحقل مطلوب"
        ]);

        foreach ($request->data as $appText) {
            $appTextDb = AppTexts::where('key', $appText['key'])->first();
            if ($appTextDb) {
                $appTextDb->update([
                    "value" => $appText['value']
                ]);
            } else {
                AppTexts::create([
                    "key" => $appText['key'],
                    "value" => $appText['value']
                ]);
            }
        }

        $appTexts = AppTexts::get();
        return response()->json([
            "status" => true,
            "item" => $appTexts
        ]);
    }



}
