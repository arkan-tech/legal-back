<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use App\Models\LawGuide;
use App\Models\City\City;
use App\Models\LawGuideLaw;
use Illuminate\Http\Request;
use GeniusTS\HijriDate\Hijri;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Http\Controllers\Controller;
use App\Models\LawGuideMainCategory;
use App\Rules\ArrayAtLeastOneRequired;
use biladina\hijridatetime\HijriDateTime;
use Google\Service\AndroidEnterprise\GoogleAuthenticationSettings;


class LawGuideController extends Controller
{
    public function mainIndex()
    {
        $mainCategories = LawGuideMainCategory::orderBy('order')->get();
        return Inertia::render('Settings/LawGuide/Main/index', get_defined_vars());
    }

    public function subIndex()
    {
        $mainCategories = LawGuideMainCategory::get();
        $subCategories = LawGuide::with(['mainCategory', 'laws'])->orderBy('order')->get();
        return Inertia::render('Settings/LawGuide/Sub/index', get_defined_vars());

    }

    public function mainIndexCreate()
    {
        return Inertia::render('Settings/LawGuide/Main/Create/index', get_defined_vars());
    }

    public function subIndexCreate()
    {
        $mainCategories = LawGuideMainCategory::get();
        return Inertia::render('Settings/LawGuide/Sub/Create/index', get_defined_vars());

    }


    public function mainIndexEdit($id)
    {
        $mainCategory = LawGuideMainCategory::findOrFail($id);
        return Inertia::render('Settings/LawGuide/Main/Edit/index', get_defined_vars());
    }

    public function subIndexEdit($id)
    {
        $mainCategories = LawGuideMainCategory::get();
        $subCategory = LawGuide::with(['mainCategory', 'laws'])->findOrFail($id);

        $released_at_hijri = Hijri::convertToHijri($subCategory->released_at)->format('Y-m-d');
        $published_at_hijri = Hijri::convertToHijri($subCategory->published_at)->format('Y-m-d');
        $subCategory['released_at_hijri'] = $released_at_hijri;
        $subCategory['published_at_hijri'] = $published_at_hijri;
        return Inertia::render('Settings/LawGuide/Sub/Edit/index', get_defined_vars());

    }


    public function createMain(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'name_en' => 'required'
        ], [
            '*' => "الحقل مطلوب"
        ]);

        $mainCategory = new LawGuideMainCategory();
        $mainCategory->name = $request->name;
        $mainCategory->name_en = $request->name_en;
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
            'name_en' => 'sometimes',
            "mainCategoryId" => 'required',
            'word_file_ar' => 'file|accepted:docx|sometimes',
            'word_file_en' => 'file|accepted:docx|sometimes',
            'pdf_file_ar' => 'file|accepted:pdf|sometimes',
            'pdf_file_en' => 'file|accepted:pdf|sometimes',
            'released_at' => 'required',
            'published_at' => 'required',
            'about' => 'required',
            'about_en' => 'sometimes',
            'status' => 'required|in:1,2',
            'release_tool' => 'required',
            'release_tool_en' => 'sometimes',
            'number_of_chapters' => 'required',
            'laws' => 'array|required', // Ensure laws array is passed
            'laws.*.name' => 'required|string', // Validate each law entry's name
            'laws.*.law' => 'required|string',  // Validate each law entry's law field


        ], [
            '*' => "الحقل مطلوب",
        ]);
        $subCategory = new LawGuide();
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->mainCategoryId;
        $subCategory->name_en = $request->name_en ?? "";
        $subCategory->about = $request->about;
        $subCategory->about_en = $request->about_en ?? '';
        $subCategory->published_at = $request->published_at;
        $subCategory->released_at = $request->released_at;
        $subCategory->status = $request->status;
        $subCategory->release_tool = $request->release_tool;
        $subCategory->release_tool_en = $request->release_tool_en ?? '';
        $subCategory->number_of_chapters = $request->number_of_chapters;
        if ($request->hasFile('pdf')) {
            $file = saveImage($request->file('pdf'), 'uploads/law_guide/');
            $subCategory->pdf_file_ar = $file;
        }
        if ($request->hasFile('pdf_en')) {
            $file = saveImage($request->file('pdf_en'), 'uploads/law_guide/');
            $subCategory->pdf_file_en = $file;
        }
        if ($request->hasFile('word')) {
            $file = saveImage($request->file('word'), 'uploads/law_guide/');
            $subCategory->word_file_ar = $file;
        }
        if ($request->hasFile('word_en')) {
            $file = saveImage($request->file('word_en'), 'uploads/law_guide/');
            $subCategory->word_file_en = $file;
        }
        $subCategory->save();

        if (!is_null($request->laws)) {

            foreach ($request->laws as $law) {
                $lawGuideLaw = new LawGuideLaw();
                $lawGuideLaw->name = $law['name'];
                $lawGuideLaw->name_en = $law['name_en'] ?? "";
                $lawGuideLaw->law_guide_id = $subCategory->id;
                $lawGuideLaw->law = $law['law'];
                $lawGuideLaw->law_en = $law['law_en'] ?? "";
                $lawGuideLaw->changes = $law['changes'];
                $lawGuideLaw->changes_en = $law['changes_en'] ?? "";
                $lawGuideLaw->save();
            }
        }


        return response()->json([
            "status" => true,
            "item" => $subCategory
        ]);
    }


    public function editMain(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'name_en' => 'required',

        ], [
            '*' => "الحقل مطلوب"
        ]);

        $mainCategory = LawGuideMainCategory::findOrFail($id);
        $mainCategory->name = $request->name;
        $mainCategory->name_en = $request->name_en;
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
            'name_en' => 'sometimes',
            "mainCategoryId" => 'required',
            'word_file_ar' => 'file|accepted:docx|sometimes',
            'word_file_en' => 'file|accepted:docx|sometimes',
            'pdf_file_ar' => 'file|accepted:pdf|sometimes',
            'pdf_file_en' => 'file|accepted:pdf|sometimes',
            'released_at' => 'required',
            'published_at' => 'required',
            'about' => 'required',
            'about_en' => 'sometimes',
            'status' => 'required|in:1,2',
            'release_tool' => 'required',
            'release_tool_en' => 'sometimes',
            'number_of_chapters' => 'required',
            'laws' => 'array|required', // Ensure laws array is passed
            'laws.*.name' => 'required|string', // Validate each law entry's name
            'laws.*.law' => 'required|string',  // Validate each law entry's law field

        ], [
            '*' => "الحقل مطلوب",
        ]);


        $subCategory = LawGuide::with('laws')->findOrFail($id);
        $subCategory->name = $request->name;
        $subCategory->name_en = $request->name_en ?? "";
        $subCategory->category_id = $request->mainCategoryId;
        $subCategory->about = $request->about;
        $subCategory->about_en = $request->about_en ?? '';
        $subCategory->published_at = $request->published_at;
        $subCategory->released_at = $request->released_at;
        $subCategory->status = $request->status;
        $subCategory->release_tool = $request->release_tool;
        $subCategory->release_tool_en = $request->release_tool_en ?? '';
        $subCategory->number_of_chapters = $request->number_of_chapters;

        if ($request->hasFile('pdf')) {
            $file = saveImage($request->file('pdf'), 'uploads/law_guide/');
            $subCategory->pdf_file_ar = $file;
        }
        if ($request->hasFile('pdf_en')) {
            $file = saveImage($request->file('pdf_en'), 'uploads/law_guide/');
            $subCategory->pdf_file_en = $file;
        }
        if ($request->hasFile('word')) {
            $file = saveImage($request->file('word'), 'uploads/law_guide/');
            $subCategory->word_file_ar = $file;
        }
        if ($request->hasFile('word_en')) {
            $file = saveImage($request->file('word_en'), 'uploads/law_guide/');
            $subCategory->word_file_en = $file;
        }
        $subCategory->save();

        if (!is_null($request->laws)) {
            $subCategory->laws()->delete();
            $lawIds = [];

            foreach ($request->laws as $law) {
                $lawGuideLaw = new LawGuideLaw();
                $lawGuideLaw->name = $law['name'];
                $lawGuideLaw->name_en = $law['name_en'] ?? "";
                $lawGuideLaw->law_guide_id = $subCategory->id;
                $lawGuideLaw->law = $law['law'];
                $lawGuideLaw->law_en = $law['law_en'] ?? "";
                $lawGuideLaw->changes = $law['changes'];
                $lawGuideLaw->changes_en = $law['changes_en'] ?? "";
                $lawGuideLaw->save();
                $lawIds[] = $lawGuideLaw->id;

            }

        }
        $subCategory = LawGuide::with('laws')->findOrFail($id);
        $released_at_hijri = Hijri::convertToHijri($subCategory->released_at)->format('Y-m-d');
        $published_at_hijri = Hijri::convertToHijri($subCategory->published_at)->format('Y-m-d');
        $subCategory['released_at_hijri'] = $released_at_hijri;
        $subCategory['published_at_hijri'] = $published_at_hijri;
        return response()->json([
            "status" => true,
            "item" => $subCategory
        ]);
    }


    public function deleteMain($id)
    {
        $item = LawGuideMainCategory::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
    public function deleteSub($id)
    {
        $item = LawGuide::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }

    public function updateMainOrder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:law_guide_main_category,id',
            'categories.*.order' => 'required|integer|min:0'
        ]);

        try {
            foreach ($request->categories as $category) {
                LawGuideMainCategory::where('id', $category['id'])->update(['order' => $category['order']]);
            }

            return response()->json([
                'status' => true,
                'message' => 'تم تحديث ترتيب الأقسام الرئيسية بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in LawGuideController@updateMainOrder: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء تحديث ترتيب الأقسام الرئيسية'
            ], 500);
        }
    }

    public function updateSubOrder(Request $request)
    {
        $request->validate([
            'guides' => 'required|array',
            'guides.*.id' => 'required|exists:law_guide,id',
            'guides.*.order' => 'required|integer|min:0'
        ]);

        try {
            foreach ($request->guides as $guide) {
                LawGuide::where('id', $guide['id'])->update(['order' => $guide['order']]);
            }

            return response()->json([
                'status' => true,
                'message' => 'تم تحديث ترتيب الأنظمة بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in LawGuideController@updateSubOrder: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء تحديث ترتيب الأنظمة'
            ], 500);
        }
    }

}

