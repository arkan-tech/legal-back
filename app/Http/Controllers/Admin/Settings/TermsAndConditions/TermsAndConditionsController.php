<?php

namespace App\Http\Controllers\Admin\Settings\TermsAndConditions;

use App\Http\Controllers\Controller;
use App\Models\Contents\Content;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TermsAndConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $rules = Content::where('type', 'lawyersrules')->first();
        return view('admin.settings.terms-conditions.index', compact('rules'));
    }

    public function ClientIndex()
    {
        $rules = Content::where('type', 'clientrules')->first();
        return view('admin.settings.terms-conditions.client.index', compact('rules'));
    }

    public function store(Request $request)
    {
        $rules = Content::where('type', 'clientrules')->first();
        $rules->update([
            'details' => $request->details
        ]);
        return redirect()->back()->with('success', 'تم التحديث بنجاح ');
    }

    public function ClientStore(Request $request)
    {
        $rules = Content::where('type', 'clientrules')->first();
        if (!is_null($rules)) {
            $rules->update([
                'details' => $request->details
            ]);
        } else {
            Content::create([
                'Title' => 'الشروط والاحكام ',
                'details' => $request->details,
                'type' => 'clientrules',
            ]);
        }

        return redirect()->back()->with('success', 'تم التحديث بنجاح ');
    }
}
