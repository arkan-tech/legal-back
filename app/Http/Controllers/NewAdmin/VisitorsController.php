<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class VisitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $visitors = Visitor::get();
        return Inertia::render('Visitors/index', get_defined_vars());
    }

    public function edit($id)
    {
        $visitor = Visitor::findOrFail($id);
        return Inertia::render('Visitors/Edit/index', get_defined_vars());
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'status' => 'required'
        ]);

        $visitor = Visitor::findOrFail($request->id);
        $visitor->name = $request->name;
        $visitor->email = $request->email;
        $visitor->status = $request->status;
        $visitor->save();
        return response()->json([
            'status' => true,
        ]);
    }

    public function destroy($id)
    {
        $visitor = Visitor::findOrFail(request('id'));
        $visitor->delete();
        return to_route('newAdmin.visitors.index');
    }

}
