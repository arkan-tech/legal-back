<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\WebpageCard;
use App\Models\WebpageWhyChooseUs;
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


class WhyChooseUsController extends Controller
{
    public function index()
    {
        $content = WebpageWhyChooseUs::get();
        return Inertia::render('LandingPageSettings/Why-Choose-Us/index', get_defined_vars());
    }
    public function update(Request $request)
    {
        $request->validate([
            "content" => "required|array",
            "content.*.text_en" => "required|string",
            "content.*.text_ar" => "required|string",

        ], [
            "content.*.text_en.required" => "حقل النص باللغة الانجليزية مطلوب",
            "content.*.text_ar.required" => "حقل النص باللغة العربية مطلوب",
        ]);

        foreach ($request->content as $index => $content) {
            $section = WebpageWhyChooseUs::find($content['id']);
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
