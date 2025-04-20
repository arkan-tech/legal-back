<?php

namespace App\Http\Controllers\Site\DigitalGuide;

use App\Http\Controllers\Controller;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyerSections;

class DigitalGuideController extends Controller
{

    public function index()
    {
        $DigitalGuideCategories = DigitalGuideCategories::where('status', 1)->get();
        return view('site.digitalguide.digitalguide', compact('DigitalGuideCategories'));
    }
    public function categories($id)
    {

        if (is_numeric($id)) {

            $lawyers_ids = LawyerSections::where('section_id', $id)->pluck('lawyer_id')->toArray();
            $Lawyers = Lawyer::whereIN('id',$lawyers_ids)->orderBy('created_at','desc')
//                ->where('digital_guide_subscription_payment_status', 1)
                ->where('accepted', 2)
                ->where('show_at_digital_guide',1)
                ->get();

            $catTitle = DigitalGuideCategories::where('status', 1)->where('id', $id)->first();
            $catTitle = $catTitle->title;

            return view('site.digitalguide.digitalguidecat', compact('catTitle', 'Lawyers'));
        }
    }

}
