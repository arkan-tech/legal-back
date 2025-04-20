<?php

namespace App\Http\Controllers\NewAdmin;

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


class OrderingContentController extends Controller
{
    public function index()
    {
        $content = WebpageSection::orderBy('order')->get();
        return Inertia::render('LandingPageSettings/Ordering-Content/index', get_defined_vars());
    }
    public function update(Request $request)
    {
        $request->validate([
            "content" => "required|array",
            "content.*.title" => "required|string",
            // Required if title is header or newsletter or footer
            "content.*.content_en" => "required_if:title,header,newsletter,footer|string",
            "content.*.content_ar" => "required_if:title,header,newsletter,footer|string",
            "content.*.order" => "required|integer",
            "content.*.image" => "required_if:title,header,why-chose-us",

        ], [
            // arabic responses
            "content.*.content_en.required_if" => "حقل المحتوى باللغة الانجليزية مطلوب",
            "content.*.content_ar.required_if" => "حقل المحتوى باللغة العربية مطلوب",
            "content.*.image.required_if" => "حقل الصورة مطلوب",
        ]);

        foreach ($request->content as $index => $content) {
            $section = WebpageSection::find($content['id']);
            $section->update([
                'order' => $content['order'],
            ]);
            if ($request->has('content.' . $index . '.content_en')) {
                $section->update([
                    'content_en' => $content['content_en'],
                ]);
            }
            if ($request->has('content.' . $index . '.content_ar')) {
                $section->update([
                    'content_ar' => $content['content_ar'],
                ]);
            }
            if ($request->hasFile('content.' . $index . '.image')) {
                $imagePath = $request->file('content.' . $index . '.image')->store('uploads/landing-page/images', 'public');

                if (!is_null($section->image_id)) {
                    Image::find($section->image_id)->update([
                        'url' => $imagePath,
                    ]);
                } else {
                    $image = Image::create([
                        'url' => $imagePath,
                    ]);
                    $section->update([
                        'image_id' => $image->id,
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 'success',
        ]);
    }
}
