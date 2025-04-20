<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EliteServiceCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EliteServiceCategoriesController extends Controller
{
    public function index()
    {
        $categories = EliteServiceCategory::all();

        return Inertia::render('Settings/EliteServiceCategories/index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return Inertia::render('Settings/EliteServiceCategories/Create/index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = EliteServiceCategory::create($validated);

        return redirect()->route('newAdmin.settings.elite-services.edit', $category->id)
            ->with('success', 'تم إنشاء الفئة بنجاح');
    }

    public function edit($id)
    {
        $category = EliteServiceCategory::findOrFail($id);

        return Inertia::render('Settings/EliteServiceCategories/Edit/index', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = EliteServiceCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'تم تحديث الفئة بنجاح',
        ]);
    }

    public function destroy($id)
    {
        $category = EliteServiceCategory::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'تم حذف الفئة بنجاح',
        ]);
    }
}
