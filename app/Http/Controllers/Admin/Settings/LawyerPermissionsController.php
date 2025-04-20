<?php

namespace App\Http\Controllers\Admin\Settings;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\LawyerPermission;
use App\Http\Controllers\Controller;

class LawyerPermissionsController extends Controller
{
    public function index()
    {
        $permissions = LawyerPermission::get();
        return Inertia::render('Settings/LawyerPermissions/index', get_defined_vars());

    }


    public function edit($id)
    {
        $permission = LawyerPermission::findOrFail($id);
        return Inertia::render('Settings/LawyerPermissions/Edit/index', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        $permission = LawyerPermission::findOrFail($id);
        $permission->update($request->all());
        return response()->json([
            "status" => true,
            'item' => $permission
        ]);
    }

}
