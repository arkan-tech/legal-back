<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Http\Tasks\Merged\Auth\ConfirmOtp;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\LawGuide\GetLawById;
use App\Http\Tasks\Merged\LawGuide\GetSubLawGuide;
use App\Http\Tasks\Merged\LawGuide\GetMainLawGuide;
use App\Http\Tasks\Merged\LawGuide\SearchLawGuides;
use App\Http\Tasks\Merged\Auth\ResendConfirmationOtp;
use App\Http\Tasks\Merged\LawGuide\GetLawsFromSubLawGuide;
use App\Http\Tasks\Merged\LawGuide\GetSubFromMainLawGuide;
use App\Models\LawGuide;
use App\Models\LawGuideLaw;

class LawGuideController extends BaseController
{
    public function getMain(Request $request, GetMainLawGuide $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getSubFromMain(Request $request, GetSubFromMainLawGuide $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getSubLawGuide(Request $request, GetSubLawGuide $task, $subId)
    {
        $response = $task->run($request, $subId);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function search(Request $request, SearchLawGuides $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getLawById(Request $request, GetLawById $task, $lawId)
    {
        $response = $task->run($lawId);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getRelatedLawGuides($id)
    {
        try {
            $lawGuide = LawGuide::findOrFail($id);
            $relatedGuides = $lawGuide->getAllRelatedLawGuides();

            return $this->sendResponse(true, "Related Law Guides", [
                'related_guides' => $relatedGuides->map(function ($guide) {
                    return [
                        'id' => $guide->id,
                        'name' => $guide->name,
                        'name_en' => $guide->name_en,
                        'about' => $guide->about,
                        'about_en' => $guide->about_en,
                    ];
                })
            ], 200);
        } catch (\Exception $e) {
            return $this->sendResponse(false, "Error fetching related law guides", null, 404);
        }
    }

    public function getRelatedLaws($lawId)
    {
        try {
            $law = LawGuideLaw::findOrFail($lawId);
            $relatedLaws = $law->getAllRelatedLaws();

            return $this->sendResponse(true, "Related Laws", [
                'related_laws' => $relatedLaws->map(function ($relatedLaw) {
                    return [
                        'id' => $relatedLaw->id,
                        'name' => $relatedLaw->name,
                        'name_en' => $relatedLaw->name_en,
                        'law' => $relatedLaw->law,
                        'law_en' => $relatedLaw->law_en,
                        'changes' => $relatedLaw->changes,
                        'changes_en' => $relatedLaw->changes_en,
                        'law_guide' => [
                            'id' => $relatedLaw->LawGuide->id,
                            'name' => $relatedLaw->LawGuide->name,
                            'name_en' => $relatedLaw->LawGuide->name_en,
                        ]
                    ];
                })
            ], 200);
        } catch (\Exception $e) {
            return $this->sendResponse(false, "Error fetching related laws", null, 404);
        }
    }
}
