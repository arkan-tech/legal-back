<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\WebpageCard;
use Inertia\Inertia;
use App\Models\Image;
use App\Models\Account;
use App\Models\Visitor;
use App\Models\AccountFcm;
use App\Models\VisitorFCM;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\WebpageSection;
use App\Models\Service\ServiceUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Devices\ClientFcmDevice;
use App\Models\Devices\LawyerFcmDevice;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Http\Controllers\PushNotificationController;


class ProductCardsController extends Controller
{
    public function index()
    {
        $content = WebpageCard::get();
        return Inertia::render('LandingPageSettings/Product-Cards/index', get_defined_vars());
    }
    public function update(Request $request)
    {
        $request->validate([
            "content" => "required|array",
            "content.*.name_en" => "required|string",
            "content.*.name_ar" => "required|string",
            "content.*.text_en" => "required|string",
            "content.*.text_ar" => "required|string",

        ], [
            "content.*.name_en.required" => "حقل الاسم باللغة الانجليزية مطلوب",
            "content.*.name_ar.required" => "حقل الاسم باللغة العربية مطلوب",
            "content.*.text_en.required" => "حقل النص باللغة الانجليزية مطلوب",
            "content.*.text_ar.required" => "حقل النص باللغة العربية مطلوب",
        ]);

        foreach ($request->content as $index => $content) {
            $section = WebpageCard::find($content['id']);

            if ($request->has('content.' . $index . '.name_en')) {
                $section->update([
                    'name_en' => $content['name_en'],
                ]);
            }
            if ($request->has('content.' . $index . '.name_ar')) {
                $section->update([
                    'name_ar' => $content['name_ar'],
                ]);
            }

            if ($request->has('content.' . $index . '.text_en')) {
                $section->update([
                    'text_en' => $content['text_en'],
                ]);
            }
            if ($request->has('content.' . $index . '.text_ar')) {
                $section->update([
                    'text_ar' => $content['text_ar'],
                ]);
            }

        }

        return response()->json([
            'status' => 'success',
        ]);
    }
}
