<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use App\Models\WebpageCard;
use App\Models\WebpageGovernment;
use App\Models\WebpageSection;
use App\Models\WebpageWhyChooseUs;
use Illuminate\Http\Request;
use App\Models\WebpageSponsor;
use App\Http\Controllers\API\BaseController;
use App\Http\Tasks\Merged\GetStaticPageTask;

class StaticPagesController extends BaseController
{
    public function show(Request $request, GetStaticPageTask $task, $key)
    {
        $response = $task->run($request, $key);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getHomepage(Request $request)
    {
        $webpageSections = WebpageSection::with('image')->orderBy('order')->get();
        $cards = WebpageCard::all()->map(function ($card) {
            return [
                'id' => $card->id,
                'name' => $card->name,
                'text' => $card->text
            ];
        });
        $sponsors = WebpageSponsor::with('image')->get();
        $governments = WebpageGovernment::with('image')->get();
        $whyChoseUs = WebpageWhyChooseUs::get();
        return $this->sendResponse(true, 'Homepage data', [
            'sections' => $webpageSections,
            'cards' => $cards,
            'sponsors' => $sponsors,
            'governments' => $governments,
            'why-chose-us' => $whyChoseUs
        ], 200);
    }
}
