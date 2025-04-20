<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\LearningPath;
use App\Models\LearningPathItem;
use App\Models\LawGuideMainCategory;
use App\Models\BookGuideCategory;
use App\Models\LawGuide;
use App\Models\BookGuide;
use App\Models\LawGuideLaw;
use App\Models\BookGuideSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;

class LearningPathController extends Controller
{
    public function index()
    {
        try {
            $learningPaths = LearningPath::with(['items'])->orderBy('order')->get()->map(function ($path) {
                return [
                    'id' => $path->id,
                    'title' => $path->title,
                    'items' => $path->items->count(),
                    'order' => $path->order
                ];
            })->toArray();

            return Inertia::render('Settings/LearningPath/index', [
                'learningPaths' => $learningPaths
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in LearningPathController@index: ' . $e->getMessage());
            return Inertia::render('Settings/LearningPath/index', [
                'learningPaths' => []
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $learningPath = LearningPath::with('items')->findOrFail($id);

            // Get main categories with their guides
            $lawGuideCategories = LawGuideMainCategory::with('lawGuides')->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'guides' => $category->lawGuides->map(function ($guide) {
                            return [
                                'id' => $guide->id,
                                'name' => $guide->name
                            ];
                        })
                    ];
                });

            $bookGuideCategories = BookGuideCategory::with('bookGuides')->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'guides' => $category->bookGuides->map(function ($guide) {
                            return [
                                'id' => $guide->id,
                                'name' => $guide->name
                            ];
                        })
                    ];
                });

            // Get all guides grouped by category
            $lawGuides = LawGuide::with('mainCategory')->get()
                ->groupBy('category_id')
                ->map(function ($guides) {
                    return $guides->map(function ($guide) {
                        return [
                            'id' => $guide->id,
                            'name' => $guide->name
                        ];
                    });
                });

            $bookGuides = BookGuide::with('category')->get()
                ->groupBy('category_id')
                ->map(function ($guides) {
                    return $guides->map(function ($guide) {
                        return [
                            'id' => $guide->id,
                            'name' => $guide->name
                        ];
                    });
                });

            // Get all laws and sections grouped by guide
            $lawGuideLaws = LawGuideLaw::with('lawGuide')->get()
                ->groupBy('law_guide_id')
                ->map(function ($laws) {
                    return $laws->map(function ($law) {
                        return [
                            'id' => $law->id,
                            'name' => $law->name
                        ];
                    });
                });

            $bookGuideSections = BookGuideSection::with('bookGuide')->get()
                ->groupBy('book_guide_id')
                ->map(function ($sections) {
                    return $sections->map(function ($section) {
                        return [
                            'id' => $section->id,
                            'name' => $section->name
                        ];
                    });
                });

            // Format existing items with category names
            $items = $learningPath->items->map(function ($item) {
                if ($item->item_type === 'law-guide') {
                    $law = LawGuideLaw::with(['lawGuide.mainCategory'])->find($item->item_id);
                    return [
                        'id' => $item->id,
                        'item_id' => $item->item_id,
                        'item_type' => $item->item_type,
                        'name' => $law ? $law->name : '',
                        'order' => $item->order,
                        'mandatory' => $item->mandatory,
                        'main_category' => $law && $law->lawGuide ? $law->lawGuide->mainCategory->name : '',
                        'sub_category' => $law && $law->lawGuide ? $law->lawGuide->name : ''
                    ];
                } else {
                    $section = BookGuideSection::with(['bookGuide.category'])->find($item->item_id);
                    return [
                        'id' => $item->id,
                        'item_id' => $item->item_id,
                        'item_type' => $item->item_type,
                        'name' => $section ? $section->name : '',
                        'order' => $item->order,
                        'mandatory' => $item->mandatory,
                        'main_category' => $section && $section->bookGuide ? $section->bookGuide->category->name : '',
                        'sub_category' => $section && $section->bookGuide ? $section->bookGuide->name : ''
                    ];
                }
            });

            $learningPath->setRelation('items', collect($items));

            return Inertia::render('Settings/LearningPath/Edit/index', [
                'learningPath' => $learningPath,
                'lawGuideCategories' => $lawGuideCategories,
                'bookGuideCategories' => $bookGuideCategories,
                'lawGuides' => $lawGuides,
                'bookGuides' => $bookGuides,
                'lawGuideLaws' => $lawGuideLaws,
                'bookGuideSections' => $bookGuideSections
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in LearningPathController@edit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحميل الصفحة');
        }
    }

    private function invalidateCache($pathId)
    {
        Cache::forget("learning_path:{$pathId}");
        Cache::forget("learning_path:{$pathId}:analytics");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'items' => 'array',
            'items.*.item_type' => 'required|in:law-guide,book-guide',
            'items.*.item_id' => 'required|integer',
            'items.*.order' => 'required|integer',
            'items.*.mandatory' => 'required|boolean',
        ]);

        $learningPath = LearningPath::findOrFail($id);
        $learningPath->title = $request->title;
        $learningPath->save();

        // Delete existing items
        $learningPath->items()->delete();

        // Create new items
        foreach ($request->items as $item) {
            $learningPath->items()->create([
                'item_type' => $item['item_type'],
                'item_id' => $item['item_id'],
                'order' => $item['order'],
                'mandatory' => $item['mandatory'],
            ]);
        }

        // Invalidate cache
        $this->invalidateCache($id);

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث المسار التعليمي بنجاح'
        ]);
    }

    public function destroy($id)
    {
        $learningPath = LearningPath::findOrFail($id);
        $learningPath->items()->delete();
        $learningPath->delete();

        // Invalidate cache
        $this->invalidateCache($id);

        return response()->json([
            'status' => true,
            'message' => 'تم حذف المسار التعليمي بنجاح'
        ]);
    }

    public function create()
    {
        try {
            // Get main categories with their guides
            $lawGuideCategories = LawGuideMainCategory::with('lawGuides')->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'guides' => $category->lawGuides->map(function ($guide) {
                            return [
                                'id' => $guide->id,
                                'name' => $guide->name
                            ];
                        })
                    ];
                });

            $bookGuideCategories = BookGuideCategory::with('bookGuides')->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'guides' => $category->bookGuides->map(function ($guide) {
                            return [
                                'id' => $guide->id,
                                'name' => $guide->name
                            ];
                        })
                    ];
                });

            // Get all guides grouped by category
            $lawGuides = LawGuide::with('mainCategory')->get()
                ->groupBy('category_id')
                ->map(function ($guides) {
                    return $guides->map(function ($guide) {
                        return [
                            'id' => $guide->id,
                            'name' => $guide->name
                        ];
                    });
                });

            $bookGuides = BookGuide::with('category')->get()
                ->groupBy('category_id')
                ->map(function ($guides) {
                    return $guides->map(function ($guide) {
                        return [
                            'id' => $guide->id,
                            'name' => $guide->name
                        ];
                    });
                });

            // Get all laws and sections grouped by guide
            $lawGuideLaws = LawGuideLaw::with('lawGuide')->get()
                ->groupBy('law_guide_id')
                ->map(function ($laws) {
                    return $laws->map(function ($law) {
                        return [
                            'id' => $law->id,
                            'name' => $law->name
                        ];
                    });
                });

            $bookGuideSections = BookGuideSection::with('bookGuide')->get()
                ->groupBy('book_guide_id')
                ->map(function ($sections) {
                    return $sections->map(function ($section) {
                        return [
                            'id' => $section->id,
                            'name' => $section->name
                        ];
                    });
                });

            return Inertia::render('Settings/LearningPath/Create/index', [
                'lawGuideCategories' => $lawGuideCategories,
                'bookGuideCategories' => $bookGuideCategories,
                'lawGuides' => $lawGuides,
                'bookGuides' => $bookGuides,
                'lawGuideLaws' => $lawGuideLaws,
                'bookGuideSections' => $bookGuideSections,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in LearningPathController@create: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحميل الصفحة');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'items' => 'array',
            'items.*.item_type' => 'required|in:law-guide,book-guide',
            'items.*.item_id' => 'required|integer',
            'items.*.order' => 'required|integer',
            'items.*.mandatory' => 'required|boolean',
        ]);

        try {
            $maxOrder = LearningPath::max('order') ?? 0;

            $learningPath = new LearningPath();
            $learningPath->title = $request->title;
            $learningPath->order = $maxOrder + 1;
            $learningPath->save();

            foreach ($request->items as $item) {
                $learningPath->items()->create([
                    'item_type' => $item['item_type'],
                    'item_id' => $item['item_id'],
                    'order' => $item['order'],
                    'mandatory' => $item['mandatory'],
                ]);
            }

            // Invalidate cache
            $this->invalidateCache($learningPath->id);

            return response()->json([
                'status' => true,
                'message' => 'تم إنشاء المسار التعليمي بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in LearningPathController@store: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء إنشاء المسار التعليمي'
            ], 500);
        }
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'paths' => 'required|array',
            'paths.*.id' => 'required|exists:learning_paths,id',
            'paths.*.order' => 'required|integer|min:0'
        ]);

        try {
            foreach ($request->paths as $path) {
                LearningPath::where('id', $path['id'])->update(['order' => $path['order']]);
                $this->invalidateCache($path['id']);
            }

            return response()->json([
                'status' => true,
                'message' => 'تم تحديث ترتيب المسارات التعليمية بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in LearningPathController@updateOrder: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء تحديث ترتيب المسارات التعليمية'
            ], 500);
        }
    }
}
