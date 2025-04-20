<?php

namespace App\Http\Tasks\Client\DigitalGuide\Filter;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use App\Models\Lawyer\LawyerSections;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountResourcePublic;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerWithServicesResource;
use App\Http\Requests\API\Client\DigitalGuide\getLawyersBaseFilterRequest;
use App\Http\Resources\API\DigitalGuide\Categories\DigitalGuideCategoriesResource;

class getLawyersBaseFilterTask extends BaseTask
{

    public function run(getLawyersBaseFilterRequest $request)
    {
        $query = Account::where('account_type', '=', 'lawyer');
        $section = DigitalGuideCategories::findOrFail($request->category_id);
        $query->when($request->has('category_id'), function ($q) use ($request) {
            $lawyers_ids = LawyerSections::where('section_id', $request->category_id)->pluck('account_details_id')->toArray();
            $q->whereHas('lawyerDetails', function ($q2) use ($lawyers_ids) {
                $q2->whereIn('id', $lawyers_ids);
            });
        });


        $query->when($request->has('country_id'), function ($q) use ($request) {
            $q->where('country_id', $request->country_id);
        });



        $query->when($request->has('city_id'), function ($q) use ($request) {
            $q->where('city', $request->city_id);
        });



        $query->when($request->has('district_id'), function ($q) use ($request) {
            $q->where('district', $request->district_id);
        });


        $query->when($request->has('gender'), function ($q) use ($request) {
            $q->where('gender', $request->gender);
        });


        $query->when($request->has('name'), function ($q) use ($request) {
            $q->where('name', 'LIKE', "%$request->name%");
        });
        $lawyers = $query->where('status', 2)->whereHas('lawyerDetails', function ($query) {
            $query->where('show_at_digital_guide', 1);
        })->orderBy('created_at', 'desc')->get();
        $lawyers = AccountResourcePublic::collection($lawyers);

        return $this->sendResponse(true, $section->title, compact('lawyers'), 200);
    }
}
