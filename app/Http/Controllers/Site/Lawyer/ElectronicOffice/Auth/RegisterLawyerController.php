<?php

namespace App\Http\Controllers\Site\Lawyer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Lawyer\Auth\RegisterSiteRequest;
use App\Models\City\City;
use App\Models\Country\Country;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\Districts\Districts;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyerSections;
use App\Models\Regions\Regions;
use File;
use Illuminate\Support\Facades\Auth;

class RegisterLawyerController extends Controller
{

    public function showRegisterForm()
    {
        $countries = Country::where('status',1)->get();
        $sections = DigitalGuideCategories::where('status', 1)->get();
        $regions = [];
        $cities = [];
        return view('site.lawyers.auth.register', get_defined_vars());
    }

    public function saveRegisterData(RegisterSiteRequest $request)
    {

        $lawyer_name = $request->fname.' '.$request->sname .' '.$request->tname.' '.$request->fourthname;
        $lawyer = new Lawyer();
        $lawyer->name = $lawyer_name;
        $lawyer->username = $lawyer_name;
        $lawyer->about = $request->about;
        $day = strlen($request->day) == 1 ?'0'.$request->day:$request->day;
        $birthday = $request->year.'-'.$request->month.'-'.$day;
        $lawyer->day =$day;
        $lawyer->month =$request->month;
        $lawyer->year =$request->year;
        $lawyer->birthday =$birthday;
        $lawyer->gender = $request->gender;
        $lawyer->type = $request->type;
        $lawyer->company_name = $request->company_name;
        $lawyer->lisences = $request->lisences;
        $lawyer->other_entity_name = $request->other_entity_name;
        $lawyer->nationality = $request->nationality;
        $lawyer->country_id = $request->country_id;
        $lawyer->region = $request->region;
        $lawyer->city = $request->city;
        $lawyer->phone_code = $request->code  ;
        $lawyer->phone = $request->phone ;
        $lawyer->identity_type = $request->identity_type ;
        $lawyer->other_idetity_type = $request->other_idetity_type ;
        $lawyer->nat_id = $request->nat_id ;
        $lawyer->degree = $request->degree ;
        $lawyer->other_degree = $request->other_degree ;
        $lawyer->sections = json_encode($request->sections)  ;
        $lawyer->has_licence_no = $request->has_licence_no =='on' ?1:0 ;
        $lawyer->licence_no = $request->licence_no ;
        $lawyer->email = $request->email ;
        $lawyer->password =bcrypt($request->password)  ;
        $lawyer->latitude = $request->lat ;
        $lawyer->longitude = $request->lon ;
        $lawyer->accept_rules = $request->rules =='on' ?1:0 ;
        $lawyer->paid_status = 0 ;
        $lawyer->is_advisor = 0 ;
        $lawyer->accepted = 1 ;
        $lawyer->special = 0 ;
        $lawyer->digital_guide_subscription = 0 ;
        $lawyer->office_request = 0 ;
        $lawyer->show_at_digital_guide = 0 ;
        $lawyer->save();
        if ($request->has('personal_image')){
            $personal_image = saveImage($request->file('personal_image'),'uploads/lawyers/personal_image/');
            $lawyer->personal_image = $personal_image;
            $lawyer->photo = $personal_image;
            $lawyer->save();
        }
        if ($request->has('logo')){
            $logo = saveImage($request->file('logo'),'uploads/lawyers/logo/');
            $lawyer->logo = $logo;
            $lawyer->save();
        }
        if ($request->has('id_file')){
            $id_file = saveImage($request->file('id_file'),'uploads/lawyers/id_file/');
            $lawyer->id_file = $id_file;

            $lawyer->save();
        }
        if ($request->has('license_file')){
            $license_file = saveImage($request->file('license_file'),'uploads/lawyers/license_file/');
            $lawyer->license_file = $license_file;
            $lawyer->license_image = $license_file;
            $lawyer->save();
        }
        if ($request->has('sections')){
            foreach ($request->sections as $section){
                LawyerSections::create([
                    'lawyer_id'=>$lawyer->id,
                    'section_id'=>$section,
                ]);
            }
        }
        return response()->json([
            'status'=>true,
            'msg' =>'تم استلام بياناتك  بنجاح , و حسابك الآن ينتظر الاعتماد من قبل الإدارة.
قد يستغرق هذا الاعتماد ٢٤ ساعة، كما ستصلك رسالة التفعيل على الايميل عند اعتماده . ,شكراً لك  .']);
    }


    public function getRegionsBaseCountryId($id){
        $regions = Regions::where('country_id', $id)->where('status',1)->get();
        $items_html = view('site.lawyers.includes.region-select', compact('regions'))->render();
        $first_region = Regions::where('country_id', $id)->where('status',1)->first();
        $first_city = City::where('region_id', $first_region)->where('status',1)->first();
        return response()->json([
            'status' => true,
            'items_html' => $items_html,
            'first_region'=>$first_region,
            'first_city'=>$first_city
        ]);
    }

    public function getCitiesBaseRegionId($id){
        $cities = City::where('region_id', $id)->where('status',1)->get();
        $items_html = view('site.lawyers.includes.cities-select', compact('cities'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }
    protected function guard()
    {
        return Auth::guard('lawyer');
    }
}
