<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use App\Models\City\City;
use Illuminate\Http\Request;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Http\Controllers\Controller;
use App\Rules\ArrayAtLeastOneRequired;
use App\Models\JudicialGuide\JudicialGuide;
use App\Models\JudicialGuide\JudicialGuideEmails;
use App\Models\JudicialGuide\JudicialGuideNumbers;
use App\Models\JudicialGuide\JudicialGuideSubEmails;
use App\Models\JudicialGuide\JudicialGuideSubNumbers;
use App\Models\JudicialGuide\JudicialGuideSubCategory;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use Google\Service\AndroidEnterprise\GoogleAuthenticationSettings;


class JudicialGuideController extends Controller
{
    public function mainIndex()
    {
        $mainCategories = JudicialGuideMainCategory::with(relations: 'subCategories.judicialGuides')->get();
        $countries = Country::get();
        return Inertia::render('Settings/JudicialGuide/Main/index', get_defined_vars());
    }

    public function subIndex()
    {
        $mainCategories = JudicialGuideMainCategory::get();
        $subCategories = JudicialGuideSubCategory::with('mainCategory', 'emails', 'numbers', 'judicialGuides')->get();
        $countries = Country::get();
        $regions = Regions::get();
        $cities = City::get();
        return Inertia::render('Settings/JudicialGuide/Sub/index', get_defined_vars());

    }

    public function index()
    {
        $judicialGuides = JudicialGuide::with('subCategory.mainCategory', 'emails', 'numbers')->get();
        $mainCategories = JudicialGuideMainCategory::get();
        $subCategories = JudicialGuideSubCategory::with('mainCategory')->get();
        $countries = Country::get();
        $regions = Regions::get();
        $cities = City::get();
        return Inertia::render('Settings/JudicialGuide/index', get_defined_vars());

    }
    public function dashboardIndex()
    {
        $mainCategories = JudicialGuideMainCategory::with(relations: 'subCategories.judicialGuides')->get();
        $subCategories = JudicialGuideSubCategory::with('mainCategory', 'emails', 'numbers', 'judicialGuides')->get();
        $countries = Country::get();
        $regions = Regions::get();
        $cities = City::get();
        $judicialGuides = JudicialGuide::with('subCategory.mainCategory', 'emails', 'numbers')->get();
        return Inertia::render('Settings/JudicialGuide/Dashboard/index', get_defined_vars());

    }
    public function mainIndexCreate()
    {
        $countries = Country::get();
        return Inertia::render('Settings/JudicialGuide/Main/Create/index', get_defined_vars());
    }

    public function subIndexCreate()
    {
        $mainCategories = JudicialGuideMainCategory::get();
        $countries = Country::get();
        $regions = Regions::get();

        return Inertia::render('Settings/JudicialGuide/Sub/Create/index', get_defined_vars());

    }

    public function indexCreate()
    {
        $mainCategories = JudicialGuideMainCategory::get();
        $countries = Country::get();
        $subCategories = JudicialGuideSubCategory::with('mainCategory')->get();
        $regions = Regions::get();
        $cities = City::get();
        return Inertia::render('Settings/JudicialGuide/Create/index', get_defined_vars());

    }
    public function mainIndexEdit($id)
    {
        $mainCategory = JudicialGuideMainCategory::findOrFail($id);
        $countries = Country::get();
        return Inertia::render('Settings/JudicialGuide/Main/Edit/index', get_defined_vars());
    }

    public function subIndexEdit($id)
    {
        $mainCategories = JudicialGuideMainCategory::get();
        $subCategory = JudicialGuideSubCategory::with('mainCategory', 'emails', 'numbers')->findOrFail($id);
        $countries = Country::get();
        $regions = Regions::get();

        return Inertia::render('Settings/JudicialGuide/Sub/Edit/index', get_defined_vars());

    }

    public function indexEdit($id)
    {
        $mainCategories = JudicialGuideMainCategory::get();
        $subCategories = JudicialGuideSubCategory::with("mainCategory")->get();
        $judicialGuide = JudicialGuide::with('subCategory.mainCategory', 'emails', 'numbers')->findOrFail($id);
        $countries = Country::get();
        $regions = Regions::get();
        $cities = City::get();
        return Inertia::render('Settings/JudicialGuide/Edit/index', get_defined_vars());

    }

    public function createMain(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => "required"
        ], [
            '*' => "الحقل مطلوب"
        ]);

        $mainCategory = new JudicialGuideMainCategory();
        $mainCategory->name = $request->name;
        $mainCategory->country_id = $request->country_id;
        $mainCategory->save();

        return response()->json([
            "status" => true,
            "item" => $mainCategory
        ]);
    }

    public function createSub(Request $request)
    {
        $request->validate([
            'name' => 'required',
            "mainCategoryId" => 'required',
            "locationUrl" => 'sometimes',
            "address" => 'sometimes',
            "workingHoursFrom" => "sometimes",
            "workingHoursTo" => "required_with:workingHoursFrom",
            "about" => "sometimes",
            "emails" => 'sometimes|array',
            "numbers" => 'sometimes|array',
            "image" => "sometimes",
            'region_id' => "required"

        ], [
            '*' => "الحقل مطلوب"
        ]);
        $subCategory = new JudicialGuideSubCategory();
        $subCategory->name = $request->name;
        $subCategory->main_category_id = $request->mainCategoryId;
        $subCategory->region_id = $request->region_id;
        if ($request->has('about')) {
            $subCategory->about = $request->about;
        }

        if ($request->has('locationUrl')) {
            $subCategory->locationUrl = $request->locationUrl;
        }
        if ($request->has('address')) {
            $subCategory->address = $request->address;
        }
        if ($request->has('working_hours_from')) {
            $subCategory->working_hours_from = $request->working_hours_from;
        }
        if ($request->has('working_hours_to')) {
            $subCategory->working_hours_to = $request->working_hours_to;
        }
        if ($request->hasFile('image')) {
            $subCategory->image = $request->hasFile('image') ? saveImage($request->file('image'), 'uploads/judicial_guide_sub/') : "";
        }
        $subCategory->save();

        if ($request->has('numbers')) {

            foreach ($request->numbers as $number) {
                JudicialGuideSubNumbers::create([
                    "phone_code" => $number["phone_code"],
                    "phone_number" => $number["phone_number"],
                    'judicial_guide_sub_id' => $subCategory->id
                ]);
            }
        }
        if ($request->has('emails')) {

            foreach ($request->emails as $email) {
                JudicialGuideSubEmails::create([
                    'email' => $email,
                    'judicial_guide_sub_id' => $subCategory->id
                ]);
            }
        }

        return response()->json([
            "status" => true,
            "item" => $subCategory
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            "workingHoursFrom" => "sometimes",
            "workingHoursTo" => "required_with:workingHoursFrom",
            "url" => "sometimes",
            "about" => "sometimes",
            "subCategoryId" => "required",
            "emails" => 'sometimes|array',
            "numbers" => 'sometimes|array',
            'city_id' => 'required',
        ], [
            '*' => "الحقل مطلوب"
        ]);


        $judicialGuide = new JudicialGuide();
        $judicialGuide->name = $request->name;
        $judicialGuide->image = $request->hasFile('image') ? saveImage($request->file('image'), 'uploads/judicial_guide/') : "";
        if ($request->workingHoursFrom) {
            $judicialGuide->working_hours_from = $request->workingHoursFrom;
            $judicialGuide->working_hours_to = $request->workingHoursTo;
        }
        $judicialGuide->url = $request->url ? $request->url : null;
        $judicialGuide->city_id = $request->city_id;
        if ($request->has('about')) {

            $judicialGuide->about = $request->about;
        }
        $judicialGuide->sub_category_id = $request->subCategoryId;
        $judicialGuide->save();

        if ($request->has('numbers')) {

            foreach ($request->numbers as $number) {
                JudicialGuideNumbers::create([
                    "phone_code" => $number["phone_code"],
                    "phone_number" => $number["phone_number"],
                    'judicial_guide_id' => $judicialGuide->id
                ]);
            }
        }
        if ($request->has('emails')) {

            foreach ($request->emails as $email) {
                JudicialGuideEmails::create([
                    'email' => $email,
                    'judicial_guide_id' => $judicialGuide->id
                ]);
            }
        }
        return response()->json([
            "status" => true,
            "item" => $judicialGuide
        ]);
    }

    public function editMain(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => "required"

        ], [
            '*' => "الحقل مطلوب"
        ]);

        $mainCategory = JudicialGuideMainCategory::findOrFail($id);
        $mainCategory->name = $request->name;
        $mainCategory->country_id = $request->country_id;
        $mainCategory->save();

        return response()->json([
            "status" => true,
            "item" => $mainCategory
        ]);
    }

    public function editSub(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            "mainCategoryId" => 'required',
            "locationUrl" => 'sometimes',
            'address' => 'sometimes',
            "workingHoursFrom" => "sometimes",
            "workingHoursTo" => "required_with:workingHoursFrom",
            "about" => "sometimes",
            "emails" => 'sometimes|array',
            "numbers" => 'sometimes|array',
            "image" => "sometimes",
            'region_id' => "required"
        ], [
            '*' => "الحقل مطلوب"
        ]);


        $subCategory = JudicialGuideSubCategory::findOrFail($id);
        $subCategory->name = $request->name;
        $subCategory->main_category_id = $request->mainCategoryId;
        $subCategory->region_id = $request->region_id;
        if ($request->has('about')) {
            $subCategory->about = $request->about;
        }

        if ($request->has('locationUrl')) {
            $subCategory->locationUrl = $request->locationUrl;
        }
        if ($request->has('address')) {
            $subCategory->address = $request->address;
        }
        if ($request->has('working_hours_from')) {
            $subCategory->working_hours_from = $request->working_hours_from;
        }
        if ($request->has('working_hours_to')) {
            $subCategory->working_hours_to = $request->working_hours_to;
        }
        if ($request->hasFile('image')) {
            $subCategory->image = $request->hasFile('image') ? saveImage($request->file('image'), 'uploads/judicial_guide_sub/') : "";
        }
        if ($request->has('numbers')) {
            $subCategory->numbers()->delete();

            foreach ($request->numbers as $number) {
                JudicialGuideSubNumbers::create([
                    "phone_code" => $number["phone_code"],
                    "phone_number" => $number["phone_number"],
                    'judicial_guide_sub_id' => $subCategory->id
                ]);
            }
        }
        if ($request->has('emails')) {
            $subCategory->emails()->delete();

            foreach ($request->emails as $email) {
                JudicialGuideSubEmails::create([
                    'email' => $email,
                    'judicial_guide_sub_id' => $subCategory->id
                ]);
            }
        }
        $subCategory->save();

        return response()->json([
            "status" => true,
            "item" => $subCategory
        ]);
    }
    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            "workingHoursFrom" => "sometimes",
            "workingHoursTo" => "required_with:workingHoursFrom",
            "url" => "sometimes",
            "about" => "sometimes",
            "subCategoryId" => "required",
            "emails" => 'sometimes|array',
            "numbers" => 'sometimes|array',
            'city_id' => "required"
        ], [
            '*' => "الحقل مطلوب"
        ]);

        $judicialGuide = JudicialGuide::findOrFail($id);
        $judicialGuide->name = $request->name;
        $judicialGuide->image = $request->hasFile('image') ? saveImage($request->file('image'), 'uploads/judicial_guide/') : "";

        if ($request->workingHoursFrom) {
            $judicialGuide->working_hours_from = $request->workingHoursFrom;
            $judicialGuide->working_hours_to = $request->workingHoursTo;
        }
        $judicialGuide->url = $request->url ? $request->url : null;
        if ($request->has('about')) {

            $judicialGuide->about = $request->about;
        }
        $judicialGuide->sub_category_id = $request->subCategoryId;
        $judicialGuide->city_id = $request->city_id;
        $judicialGuide->save();
        if ($request->has('numbers')) {

            $judicialGuide->numbers()->delete();
            foreach ($request->numbers as $number) {
                JudicialGuideNumbers::create([
                    "phone_code" => $number["phone_code"],
                    "phone_number" => $number["phone_number"],
                    'judicial_guide_id' => $judicialGuide->id
                ]);
            }
        }
        if ($request->has('emails')) {

            $judicialGuide->emails()->delete();
            foreach ($request->emails as $email) {
                JudicialGuideEmails::create([
                    'email' => $email,
                    'judicial_guide_id' => $judicialGuide->id
                ]);
            }
        }

        return response()->json([
            "status" => true,
            "item" => $judicialGuide
        ]);
    }

    public function deleteMain($id)
    {
        $item = JudicialGuideMainCategory::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
    public function deleteSub($id)
    {
        $item = JudicialGuideSubCategory::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
    public function delete($id)
    {
        $item = JudicialGuide::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
}
