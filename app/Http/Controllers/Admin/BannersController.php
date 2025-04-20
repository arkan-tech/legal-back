<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannersController extends Controller
{

    public function index()
    {
        $banners = Banners::get();
        return Inertia::render('Settings/Banners/index', get_defined_vars());
    }
    public function create()
    {
        $banners = Banners::get();
        return Inertia::render('Settings/Banners/Create/index', get_defined_vars());
    }
    public function edit($id)
    {
        $banner = Banners::findOrFail($id);
        return Inertia::render('Settings/Banners/Edit/index', get_defined_vars());
    }
    public function store(Request $request)
    {
        $request->validate([
            "image" => "required|file",
            'expires_at' => 'sometimes'
        ]);

        $item = Banners::create([
            "image" => saveImage($request->file('image'), 'uploads/banners'),
            'expires_at' => $request->expires_at ? Carbon::parse($request->expires_at) : null
        ]);
        return to_route('newAdmin.settings.banners.edit', ['id' => $item->id]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            "image" => "sometimes|file",
            'expires_at' => 'sometimes'
        ]);
        $banner = Banners::findOrFail($id);
        $banner->update([
            "image" => $request->hasFile('image') ? saveImage($request->file, 'uplodas/banners') : null,
            'expires_at' => $request->expires_at ? Carbon::parse($request->expires_at) : null
        ]);
        return response()->json([
            "status" => true,
            "item" => $banner
        ]);
    }
    public function destroy($id)
    {
        $banner = Banners::findOrFail($id);
        $banner->delete();
        return to_route('newAdmin.settings.banners.index');
    }

}
