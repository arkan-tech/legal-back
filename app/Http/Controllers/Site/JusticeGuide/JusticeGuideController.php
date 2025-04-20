<?php

namespace App\Http\Controllers\Site\JusticeGuide;

use App\Http\Controllers\Controller;
use App\Models\JusticeGuide\JusticeGuide;
use App\Models\JusticeGuideCategory\JusticeGuideCategory;
use Illuminate\Http\Response;

class JusticeGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $justice_guides = JusticeGuideCategory::where('parent_id', 0)->get();
        return view('site.justice_guide.justiceguide', compact('justice_guides'));
    }

    public function Categories($id)
    {
        $justice_guides =  JusticeGuideCategory::where('parent_id', $id)->get();

        return view('site.justice_guide.justiceguidecat', compact('justice_guides'));
    }

    public function justiceGuideCatContent($id)
    {
        $justice_guides = JusticeGuide::where('category_id', $id)->get();
        $category =  JusticeGuideCategory::where('id', $id)->first();
        return view('site.justice_guide.justiceguidecatcontent', compact('justice_guides', 'category'));
    }

    public function viewBuilding($id)
    {
        $building = JusticeGuide::where('id', $id)->first();
        return view('site.justice_guide.buildings', compact('building'));
    }
}
