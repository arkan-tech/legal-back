<?php

namespace App\Http\Tasks\Merged\LawGuide;

use App\Http\Resources\LawGuideResourceShort;
use App\Models\LawGuide;
use App\Models\LawGuideLaw;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\API\Splash\Splash;
use App\Models\LawGuideMainCategory;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\API\LawGuide\LawGuideResource;
use App\Models\JudicialGuide\JudicialGuideSubCategory;
use App\Models\JudicialGuide\JudicialGuideMainCategory;
use App\Http\Resources\API\LawGuide\LawGuideLawResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideResource;
use App\Http\Resources\API\LawGuide\LawGuideMainCategoryResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideSubCategoryResource;
use App\Http\Resources\API\JudicialGuide\JudicialGuideMainCategoryResource;

class SearchLawGuides extends BaseTask
{

    public function run(Request $request)
    {

        $searchTerm = $request->searchTerm;
        $lawGuideMainCategoryId = $request->lawGuideMainCategoryId;
        $lawGuideSubCategoryId = $request->lawGuideSubCategoryId;
        $lawGuideMainCategories = [];
        $lawGuide = [];
        $laws = [];
        $mainCategoriesPage = $request->query('mainCategoriesPage') ?? 1;
        $lawGuidePage = $request->query('lawGuidePage') ?? 1;
        $lawsPage = $request->query('lawsPage') ?? 1;
        $relatedLawGuidesPage = $request->query('relatedLawGuidesPage') ?? 1;
        $perPage = $request->query('perPage') ?? 10;
        if (is_null($lawGuideMainCategoryId) and is_null($lawGuideSubCategoryId)) {
            $lawGuideMainCategories = LawGuideMainCategory::where('name', 'like', "%{$searchTerm}%")->paginate($perPage, page: $mainCategoriesPage);
            $lawGuide = LawGuide::where('name', 'like', "%{$searchTerm}%")->paginate($perPage, page: $lawGuidePage);
            $laws = LawGuideLaw::where('name', 'like', "%{$searchTerm}%")->orWhere(
                'law',
                'like',
                "%{$searchTerm}%"
            )->orWhere('changes', 'like', "%{$searchTerm}%")->paginate($perPage, page: $lawsPage);
            $relatedLawGuides = LawGuide::whereHas('laws', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")->orWhere(
                    'law',
                    'like',
                    "%{$searchTerm}%"
                )->orWhere('changes', 'like', "%{$searchTerm}%");
            })->paginate($perPage, page: $relatedLawGuidesPage);
        } else if (!is_null($lawGuideMainCategoryId) and is_null($lawGuideSubCategoryId)) {
            $lawGuide = LawGuide::where('name', 'like', "%{$searchTerm}%")->where('category_id', $lawGuideMainCategoryId)->paginate($perPage, page: $lawGuidePage);
            $laws = LawGuideLaw::whereHas('lawGuide', function ($query) use ($lawGuideMainCategoryId) {
                $query->where('category_id', $lawGuideMainCategoryId);
            })->where('name', 'like', "%{$searchTerm}%")->orWhere(
                    'law',
                    'like',
                    "%{$searchTerm}%"
                )->orWhere('changes', 'like', "%{$searchTerm}%")->paginate($perPage, page: $lawsPage);
            $relatedLawGuides = LawGuide::where('category_id', $lawGuideMainCategoryId)->whereHas('laws', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")->orWhere(
                    'law',
                    'like',
                    "%{$searchTerm}%"
                )->orWhere('changes', 'like', "%{$searchTerm}%");
            })->paginate($perPage, page: $relatedLawGuidesPage);
        } else {
            $laws = LawGuideLaw::whereHas('lawGuide', function ($query) use ($lawGuideSubCategoryId) {
                $query->where('id', $lawGuideSubCategoryId);
            })->where('name', 'like', "%{$searchTerm}%")->orWhere(
                    'law',
                    'like',
                    "%{$searchTerm}%"
                )->orWhere('changes', 'like', "%{$searchTerm}%")->paginate($perPage, page: $lawsPage);
            $relatedLawGuides = LawGuide::where('id', $lawGuideSubCategoryId)->whereHas('laws', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")->orWhere(
                    'law',
                    'like',
                    "%{$searchTerm}%"
                )->orWhere('changes', 'like', "%{$searchTerm}%");
            })->paginate($perPage, page: $relatedLawGuidesPage);
        }
        $lawGuideMainCategoriesResource = $lawGuideMainCategories->map(function ($category) {
            return new LawGuideMainCategoryResource($category, true);
        });
        $lawGuideMainCategories = [
            "data" => $lawGuideMainCategoriesResource,
            "total" => !is_array($lawGuideMainCategories) ? $lawGuideMainCategories->total() : 0,
            "per_page" => !is_array($lawGuideMainCategories) ? $lawGuideMainCategories->perPage() : $perPage,
            "current_page" => !is_array($lawGuideMainCategories) ? $lawGuideMainCategories->currentPage() : 1,
            "last_page" => !is_array($lawGuideMainCategories) ? $lawGuideMainCategories->lastPage() : 1,
        ];
        $lawGuideResource = LawGuideResource::collection($lawGuide);
        $lawGuide = [
            "data" => $lawGuideResource,
            "total" => !is_array($lawGuide) ? $lawGuide->total() : 0,
            "per_page" => !is_array($lawGuide) ? $lawGuide->perPage() : $perPage,
            "current_page" => !is_array($lawGuide) ? $lawGuide->currentPage() : 1,
            "last_page" => !is_array($lawGuide) ? $lawGuide->lastPage() : 1,
        ];
        $lawsResource = LawGuideLawResource::collection($laws);
        $laws = [
            "data" => $lawsResource,
            "total" => $laws->total(),
            "per_page" => $laws->perPage(),
            "current_page" => $laws->currentPage(),
            "last_page" => $laws->lastPage(),
        ];
        $relatedLawGuidesResource = $relatedLawGuides->map(function ($guide) {
            return new LawGuideResourceShort($guide, true);
        });
        $relatedLawGuides = [
            "data" => $relatedLawGuidesResource,
            "total" => $relatedLawGuides->total(),
            "per_page" => $relatedLawGuides->perPage(),
            "current_page" => $relatedLawGuides->currentPage(),
            "last_page" => $relatedLawGuides->lastPage(),
        ];
        // if (is_null($lawGuideMainCategoryId) and is_null($lawGuideSubCategoryId)) {
        //     $lawGuideMainCategories = LawGuideMainCategory::where('name', 'like', "%{$searchTerm}%")->get();
        //     $lawGuide = LawGuide::where('name', 'like', "%{$searchTerm}%")->get();
        //     $laws = LawGuideLaw::where('name', 'like', "%{$searchTerm}%")->orWhere(
        //         'law',
        //         'like',
        //         "%{$searchTerm}%"
        //     )->orWhere('changes', 'like', "%{$searchTerm}%")->get();
        //     $relatedLawGuides = LawGuide::whereHas('laws', function ($query) use ($searchTerm) {
        //         $query->where('name', 'like', "%{$searchTerm}%")->orWhere(
        //             'law',
        //             'like',
        //             "%{$searchTerm}%"
        //         )->orWhere('changes', 'like', "%{$searchTerm}%");
        //     })->get();
        // } else if (!is_null($lawGuideMainCategoryId) and is_null($lawGuideSubCategoryId)) {
        //     $lawGuide = LawGuide::where('name', 'like', "%{$searchTerm}%")->where('category_id', $lawGuideMainCategoryId)->get();
        //     $laws = LawGuideLaw::whereHas('lawGuide', function ($query) use ($lawGuideMainCategoryId) {
        //         $query->where('category_id', $lawGuideMainCategoryId);
        //     })->where('name', 'like', "%{$searchTerm}%")->orWhere(
        //             'law',
        //             'like',
        //             "%{$searchTerm}%"
        //         )->orWhere('changes', 'like', "%{$searchTerm}%")->get();
        //     $relatedLawGuides = LawGuide::where('category_id', $lawGuideMainCategoryId)->whereHas('laws', function ($query) use ($searchTerm) {
        //         $query->where('name', 'like', "%{$searchTerm}%")->orWhere(
        //             'law',
        //             'like',
        //             "%{$searchTerm}%"
        //         )->orWhere('changes', 'like', "%{$searchTerm}%");
        //     })->get();
        // } else {
        //     $laws = LawGuideLaw::whereHas('lawGuide', function ($query) use ($lawGuideSubCategoryId) {
        //         $query->where('id', $lawGuideSubCategoryId);
        //     })->where('name', 'like', "%{$searchTerm}%")->orWhere(
        //             'law',
        //             'like',
        //             "%{$searchTerm}%"
        //         )->orWhere('changes', 'like', "%{$searchTerm}%")->get();
        //     $relatedLawGuides = LawGuide::where('id', $lawGuideSubCategoryId)->whereHas('laws', function ($query) use ($searchTerm) {
        //         $query->where('name', 'like', "%{$searchTerm}%")->orWhere(
        //             'law',
        //             'like',
        //             "%{$searchTerm}%"
        //         )->orWhere('changes', 'like', "%{$searchTerm}%");
        //     })->get();
        // }
        // $lawGuideMainCategories = LawGuideMainCategoryResource::collection($lawGuideMainCategories);
        // $lawGuide = LawGuideResource::collection($lawGuide);
        // $laws = LawGuideLawResource::collection($laws);
        // $relatedLawGuides = LawGuideResourceShort::collection($relatedLawGuides);

        return $this->sendResponse(true, 'Laws Search', compact('lawGuideMainCategories', 'lawGuide', 'laws', 'relatedLawGuides'), 200);
    }
}
