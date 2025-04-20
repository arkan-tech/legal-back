<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\BookGuide;
use App\Models\BookGuideCategory;
use App\Models\BookGuideSection;
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


class BookGuideController extends Controller
{
    public function mainIndex()
    {
        $mainCategories = BookGuideCategory::get()->makeVisible(['name_en', 'name_ar']);
        return Inertia::render('Settings/BookGuide/Main/index', get_defined_vars());
    }

    public function subIndex()
    {
        $mainCategories = BookGuideCategory::get()->makeVisible(['name_en', 'name_ar']);
        $subCategories = BookGuide::with(['category', 'sections'])->get()->makeVisible(['name_en', 'name_ar', 'word_file_en', 'word_file_ar', 'pdf_file_en', 'pdf_file_ar', 'about_ar', 'about_en', 'release_tool_ar', 'release_tool_en']);
        return Inertia::render('Settings/BookGuide/Sub/index', get_defined_vars());

    }

    public function mainIndexCreate()
    {
        return Inertia::render('Settings/BookGuide/Main/Create/index', get_defined_vars());
    }

    public function subIndexCreate()
    {
        $mainCategories = BookGuideCategory::get()->makeVisible(['name_en', 'name_ar']);
        return Inertia::render('Settings/BookGuide/Sub/Create/index', get_defined_vars());

    }


    public function mainIndexEdit($id)
    {
        $mainCategory = BookGuideCategory::findOrFail($id)->makeVisible(['name_en', 'name_ar']);
        return Inertia::render('Settings/BookGuide/Main/Edit/index', get_defined_vars());
    }

    public function subIndexEdit($id)
    {
        $mainCategories = BookGuideCategory::get()->makeVisible(['name_en', 'name_ar']);
        $subCategory = BookGuide::with(['category', 'sections'])->findOrFail($id)->makeVisible(['name_en', 'name_ar', 'word_file_en', 'word_file_ar', 'pdf_file_en', 'pdf_file_ar', 'about_ar', 'about_en', 'release_tool_ar', 'release_tool_en']);

        $released_at_hijri = Hijri::convertToHijri($subCategory->released_at)->format('Y-m-d');
        $published_at_hijri = Hijri::convertToHijri($subCategory->published_at)->format('Y-m-d');
        $subCategory['released_at_hijri'] = $released_at_hijri;
        $subCategory['published_at_hijri'] = $published_at_hijri;
        return Inertia::render('Settings/BookGuide/Sub/Edit/index', get_defined_vars());

    }


    public function createMain(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'sometimes'
        ], [
            '*' => "الحقل مطلوب"
        ]);

        $mainCategory = new BookGuideCategory();
        $mainCategory->name_ar = $request->name_ar;
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
            'name_ar' => 'required',
            'name_en' => 'sometimes',
            "category_id" => 'required',
            'word_file_ar' => 'file|accepted:docx|sometimes',
            'word_file_en' => 'file|accepted:docx|sometimes',
            'pdf_file_ar' => 'file|accepted:pdf|sometimes',
            'pdf_file_en' => 'file|accepted:pdf|sometimes',
            'released_at' => 'required',
            'published_at' => 'required',
            'about_ar' => 'required',
            'about_en' => 'sometimes',
            'status' => 'required|in:1,2',
            'release_tool_ar' => 'required',
            'release_tool_en' => 'sometimes',
            'number_of_chapters' => 'required',
            'sections' => 'array|required', // Ensure sections array is passed
            'sections.*.name_ar' => 'required|string', // Validate each law entry's name
            'sections.*.section_text_ar' => 'required|string',  // Validate each law entry's law field


        ], [
            '*' => "الحقل مطلوب",
        ]);
        $subCategory = new BookGuide();
        $subCategory->name_ar = $request->name_ar;
        $subCategory->category_id = $request->category_id;
        $subCategory->name_en = $request->name_en ?? "";
        $subCategory->about_ar = $request->about_ar;
        $subCategory->about_en = $request->about_en ?? '';
        $subCategory->published_at = $request->published_at;
        $subCategory->released_at = $request->released_at;
        $subCategory->status = $request->status;
        $subCategory->release_tool_ar = $request->release_tool_ar;
        $subCategory->release_tool_en = $request->release_tool_en ?? '';
        $subCategory->number_of_chapters = $request->number_of_chapters;
        if ($request->hasFile('pdf')) {
            $file = saveImage($request->file('pdf'), 'uploads/book_guide/');
            $subCategory->pdf_file_ar = $file;
        }
        if ($request->hasFile('pdf_en')) {
            $file = saveImage($request->file('pdf_en'), 'uploads/book_guide/');
            $subCategory->pdf_file_en = $file;
        }
        if ($request->hasFile('word')) {
            $file = saveImage($request->file('word'), 'uploads/book_guide/');
            $subCategory->word_file_ar = $file;
        }
        if ($request->hasFile('word_en')) {
            $file = saveImage($request->file('word_en'), 'uploads/book_guide/');
            $subCategory->word_file_en = $file;
        }
        $subCategory->save();

        if (!is_null($request->sections)) {

            foreach ($request->sections as $section) {
                $bookSection = new BookGuideSection();
                $bookSection->name_ar = $section['name_ar'];
                $bookSection->name_en = $section['name_en'] ?? "";
                $bookSection->book_guide_id = $subCategory->id;
                $bookSection->section_text_ar = $section['section_text_ar'];
                $bookSection->section_text_en = $section['section_text_en'] ?? "";
                $bookSection->changes_ar = $section['changes_ar'];
                $bookSection->changes_en = $section['changes_en'] ?? "";
                $bookSection->save();
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
            'name_ar' => 'required',
            'name_en' => 'required',

        ], [
            '*' => "الحقل مطلوب"
        ]);

        $mainCategory = BookGuideCategory::findOrFail($id);
        $mainCategory->name_ar = $request->name_ar;
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
            'name_ar' => 'required',
            'name_en' => 'sometimes',
            "category_id" => 'required',
            'word_file_ar' => 'file|accepted:docx|sometimes',
            'word_file_en' => 'file|accepted:docx|sometimes',
            'pdf_file_ar' => 'file|accepted:pdf|sometimes',
            'pdf_file_en' => 'file|accepted:pdf|sometimes',
            'released_at' => 'required',
            'published_at' => 'required',
            'about_ar' => 'required',
            'about_en' => 'sometimes',
            'status' => 'required|in:1,2',
            'release_tool' => 'required',
            'release_tool_en' => 'sometimes',
            'number_of_chapters' => 'required',
            'sections' => 'array|required', // Ensure sections array is passed
            'sections.*.name_ar' => 'required|string', // Validate each law entry's name
            'sections.*.name_en' => 'sometimes|string', // Validate each law entry's name
            'sections.*.section_text_ar' => 'required|string',  // Validate each law entry's law field
            'sections.*.section_text_en' => 'sometimes|string',  // Validate each law entry's law field

        ], [
            '*' => "الحقل مطلوب",
        ]);


        $subCategory = BookGuide::with('sections')->findOrFail($id);
        $subCategory->name_ar = $request->name_ar;
        $subCategory->name_en = $request->name_en ?? "";
        $subCategory->category_id = $request->mainCategoryId;
        $subCategory->about_ar = $request->about_ar;
        $subCategory->about_en = $request->about_en ?? '';
        $subCategory->published_at = $request->published_at;
        $subCategory->released_at = $request->released_at;
        $subCategory->status = $request->status;
        $subCategory->release_tool_ar = $request->release_tool_ar;
        $subCategory->release_tool_en = $request->release_tool_en ?? '';
        $subCategory->number_of_chapters = $request->number_of_chapters;

        if ($request->hasFile('pdf')) {
            $file = saveImage($request->file('pdf'), 'uploads/book_guide/');
            $subCategory->pdf_file_ar = $file;
        }
        if ($request->hasFile('pdf_en')) {
            $file = saveImage($request->file('pdf_en'), 'uploads/book_guide/');
            $subCategory->pdf_file_en = $file;
        }
        if ($request->hasFile('word')) {
            $file = saveImage($request->file('word'), 'uploads/book_guide/');
            $subCategory->word_file_ar = $file;
        }
        if ($request->hasFile('word_en')) {
            $file = saveImage($request->file('word_en'), 'uploads/book_guide/');
            $subCategory->word_file_en = $file;
        }
        $subCategory->save();

        if (!is_null($request->sections)) {
            $subCategory->sections()->delete();

            foreach ($request->sections as $section) {
                $bookSection = new BookGuideSection();
                $bookSection->name_ar = $section['name_ar'];
                $bookSection->name_en = $section['name_en'] ?? "";
                $bookSection->book_guide_id = $subCategory->id;
                $bookSection->section_text_ar = $section['section_text_ar'];
                $bookSection->section_text_en = $section['section_text_en'] ?? "";
                $bookSection->changes_ar = $section['changes_ar'];
                $bookSection->changes_en = $section['changes_en'] ?? "";
                $bookSection->save();
            }
        }
        $subCategory = BookGuide::with('sections')->findOrFail($id);
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
        $item = BookGuideCategory::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }
    public function deleteSub($id)
    {
        $item = BookGuide::findOrFail($id);
        $item->delete();

        return response()->json([
            "stauts" => true
        ]);
    }

}
