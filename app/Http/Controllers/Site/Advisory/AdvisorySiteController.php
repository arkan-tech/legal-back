<?php

namespace App\Http\Controllers\Site\Advisory;

use App\Http\Controllers\Controller;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyersAdvisorys;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdvisorySiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $DigitalGuideCategories = AdvisoryCommittee::where('status', 1)->get();
        return view('site.advisory.advisory', compact('DigitalGuideCategories'));
    }

    public function advisoryCat($id)
    {
        if (is_numeric($id)) {
            $AdvisoryCommittee = LawyersAdvisorys::where('advisory_id',$id)->pluck('lawyer_id')->toArray();
            $Lawyers = Lawyer::where('is_advisor', 1)->whereIN('id', $AdvisoryCommittee)->where('accepted', '2')->get();
            $catTitle = AdvisoryCommittee::where('id', $id)->first();
            $catTitle = $catTitle->title;
            return view('site.advisory.advisorycat', compact('catTitle', 'Lawyers'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
