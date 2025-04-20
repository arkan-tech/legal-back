<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\API\LawGuide\LawGuideMainCategoryResource;
use App\Http\Resources\API\LawGuide\LawGuideResource;
use App\Http\Resources\BookGuideCategoryResource;
use App\Http\Resources\BookGuideResourceShort;
use App\Http\Resources\LawGuideResourceShort;
use App\Models\LearningPath;
use Illuminate\Http\Request;
use App\Models\LearningPathItem;
use App\Http\Controllers\Controller;
use App\Models\LearningPathProgress;
use App\Http\Resources\API\LearningPathResource;
use Illuminate\Support\Facades\Cache;
use App\Models\FavouriteLearningPathItem;

class LearningPathController extends BaseController
{
    public function index()
    {
        $paths = LearningPath::with('items.progress')->orderBy('order')->get();
        $paths = $paths->map(function ($path) {
            $allItems = $path->items->sortBy('order')->map(function ($item) {
                $itemData = [
                    'id' => $item->item->id,
                    'name' => $item->item->name,
                    'locked' => $item->locked,
                    'type' => $item->item_type,
                    'order' => $item->order
                ];

                if ($item->item_type == 'law-guide') {
                    $itemData['law_guide'] = $item->item->lawGuide;
                } else if ($item->item_type == 'book-guide') {
                    $itemData['book_guide'] = $item->item->bookGuide;
                }

                return $itemData;
            })->values()->all();

            return [
                'path_id' => $path->id,
                'title' => $path->title,
                'items' => $allItems
            ];
        });

        return $this->sendResponse(true, "Learning Paths", compact('paths'), 200);
    }

    public function markAsRead(Request $request)
    {
        $id = $request->item_id;
        // Validate the id is a learning path item
        $item = LearningPathItem::findOrFail($id);

        // Check if the item is locked
        if ($item->locked) {
            return $this->sendResponse(false, "Cannot mark locked item", [], 403);
        }

        // validate that type is read/learned
        if ($request->type != 'learned' && $request->type != 'read') {
            return $this->sendResponse(false, "Invalid type", [], 400);
        }

        $progress = LearningPathProgress::updateOrCreate([
            'learning_path_items' => $id,
            'type' => $request->type,
            'account_id' => auth()->id(),
        ]);

        // Invalidate the cache for this learning path
        $this->invalidateCache($item->learning_path_id);

        return $this->sendResponse(true, "Marked as type", compact('progress'), 200);
    }


    public function getAllPaths()
    {
        $paths = LearningPath::orderBy('order')->get(['id', 'title']);
        return $this->sendResponse(true, "Learning Paths", compact('paths'), 200);
    }

    private function getCacheKey($pathId)
    {
        return "learning_path:{$pathId}";
    }

    private function invalidateCache($pathId)
    {
        Cache::forget($this->getCacheKey($pathId));
        Cache::forget($this->getCacheKey($pathId) . ':analytics');
    }

    public function getLearningPathItems($id)
    {
        $cacheKey = $this->getCacheKey($id);
        $analyticsKey = $cacheKey . ':analytics';

        // Fetch the path outside the cache closure to ensure it's accessible
        $path = LearningPath::with([
            'items.progress',
            'items.lawGuideLaw.lawGuide',
            'items.bookGuideSection.bookGuide'
        ])->findOrFail($id);

        // Try to get items from cache
        $items = Cache::remember($cacheKey, now()->addHours(24), function () use ($path) {
            return $path->items->sortBy('order')->groupBy(function ($item) {
                if ($item->item_type == 'law-guide') {
                    return 'law-guide-' . $item->item->lawGuide->id;
                } else if ($item->item_type == 'book-guide') {
                    return 'book-guide-' . $item->item->bookGuide->id;
                }
            })->map(function ($group) {
                $firstItem = $group->first();
                $type = $firstItem->item_type;

                return [
                    'type' => $type,
                    'subcategory' => $type == 'law-guide' ?
                        new LawGuideResourceShort($firstItem->item->lawGuide, false) :
                        new BookGuideResourceShort($firstItem->item->bookGuide, false),
                    'items' => $group->map(function ($item) {
                        return [
                            'id' => $item->item->id,
                            'name' => $item->item->name,
                            'learning_path_item_id' => $item->id,
                            'order' => $item->order
                        ];
                    })->sortBy('order')->values()->all()
                ];
            })->sortBy(function ($group) {
                return collect($group['items'])->min('order');
            })->values()->all();
        });

        // Fetch user-specific data separately
        $userSpecificData = $path->items->map(function ($item) {
            $isFavourite = FavouriteLearningPathItem::where('account_id', auth()->id())
                ->where('learning_path_item_id', $item->id)
                ->exists();

            return [
                'id' => $item->item->id,
                'locked' => $item->locked,
                'mandatory' => $item->mandatory,
                'alreadyDone' => $item->progress ? true : false,
                'learning_path_item_id' => $item->id,
                'isFavourite' => $isFavourite
            ];
        });

        // merge user specific data with cached path items
        $items = collect($items)->map(function ($group) use ($userSpecificData) {
            $group['items'] = collect($group['items'])->map(function ($item) use ($userSpecificData) {
                $userData = $userSpecificData->firstWhere('learning_path_item_id', $item['learning_path_item_id']);
                return array_merge($item, $userData ? $userData : []);
            })->all();
            return $group;
        })->all();

        // Fetch user-specific analytics separately
        $path = LearningPath::with('items.progress')->findOrFail($id);
        $analytics = $this->calculateAnalytics($path->items, 'all');
        return $this->sendResponse(true, "Learning Path Items", compact('items', 'analytics'), 200);
    }

    private function calculateAnalytics($items, $type)
    {
        $userId = auth()->user()->id;
        $learningPathId = $items->first()->learning_path_id;
        // Calculate basic item statistics
        $totalItems = $items->count();

        // Count items that have progress
        $doneItems = $items->filter(function ($item) use ($userId) {
            return $item->progress && $item->progress->where('account_id', $userId)->count() > 0;
        })->count();

        $notDoneItems = $totalItems - $doneItems;

        // Group items by subcategories
        $subcategories = $items->groupBy(function ($item) {
            if ($item->item_type == 'law-guide') {
                return 'law-guide-' . $item->item->lawGuide->id;
            } else if ($item->item_type == 'book-guide') {
                return 'book-guide-' . $item->item->bookGuide->id;
            }
        });

        $totalSubCategories = $subcategories->count();

        $doneSubCategories = $subcategories->filter(function ($group) use ($userId) {
            return $group->every(function ($item) use ($userId) {
                return $item->progress && $item->progress->where('account_id', $userId)->where('type', 'read')->count() > 0;
            });
        })->count();

        $notDoneSubCategories = $totalSubCategories - $doneSubCategories;
        $favouriteLearningPathItems = FavouriteLearningPathItem::where('account_id', $userId)->with(
            'learningPathItem.learningPath',

        )->whereHas('learningPathItem.learningPath', function ($query) use ($learningPathId) {
            $query->where('id', $learningPathId);
        })->get();
        return [
            'total_items' => $totalItems,
            'done_items' => $doneItems,
            'not_done_items' => $notDoneItems,
            'total_subcategories' => $totalSubCategories,
            'done_subcategories' => $doneSubCategories,
            'not_done_subcategories' => $notDoneSubCategories,
            'total_favourite' => $favouriteLearningPathItems->count(),
            'law_guides_favourite' => $favouriteLearningPathItems->filter(function ($item) {
                return $item->learningPathItem->item_type === 'law-guide';
            })->count(),
            'book_guides_favourite' => $favouriteLearningPathItems->filter(function ($item) {
                return $item->learningPathItem->item_type === 'book-guide';
            })->count(),
        ];
    }
}
