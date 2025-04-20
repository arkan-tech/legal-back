<?php

namespace App\Http\Controllers\Admin;

use App\Models\StaticPage;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IdentityController extends Controller
{
    public function index()
    {
        $identity = StaticPage::get();

        // Helper function to safely decode JSON and ensure array
        $safeJsonDecode = function ($content) {
            if (empty($content))
                return [];
            $decoded = json_decode($content, true);
            return is_array($decoded) ? $decoded : [];
        };

        // Get all static pages
        $whoAreWe = StaticPage::where('key', 'who-are-we')->first();
        $termsAndConditions = StaticPage::where('key', 'terms-and-conditions')->first();
        $privacyPolicy = StaticPage::where('key', 'privacy-policy')->first();
        $socialMedia = StaticPage::where('key', 'social-media')->first();
        $faq = StaticPage::where('key', 'faq')->first();

        return Inertia::render('Settings/Identity/index', [
            'identity' => [
                ['key' => 'who-are-we', 'content' => $whoAreWe ? $whoAreWe->content : '[]'],
                ['key' => 'terms-and-conditions', 'content' => $termsAndConditions ? $termsAndConditions->content : '[]'],
                ['key' => 'privacy-policy', 'content' => $privacyPolicy ? $privacyPolicy->content : '[]'],
                ['key' => 'social-media', 'content' => $socialMedia ? $socialMedia->content : '[]'],
                ['key' => 'faq', 'content' => $faq ? $faq->content : '[]'],
            ]
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            "who_are_we" => "required|array",
            "who_are_we.*.title" => "required|string",
            "who_are_we.*.data" => "required|string",
            "terms_and_conditions" => "required|array",
            "terms_and_conditions.*.title" => "required|string",
            "terms_and_conditions.*.data" => "required|string",
            "privacy_policy" => "required|array",
            "privacy_policy.*.title" => "required|string",
            "privacy_policy.*.data" => "required|string",
            "social_media" => "required|array",
            "faq" => "required|array",
            "faq.*.title" => "required|string",
            "faq.*.data" => "required|string"
        ], [
            "*.required" => "هذا الحقل مطلوب",
            "*.*.title.required" => "العنوان مطلوب لكل قسم",
            "*.*.data.required" => "المحتوى مطلوب لكل قسم"
        ]);

        $who_are_we = StaticPage::where('key', "who-are-we")->first();
        $who_are_we->update([
            "content" => json_encode($request->who_are_we)
        ]);

        $terms_and_conditions = StaticPage::where('key', "terms-and-conditions")->first();
        $terms_and_conditions->update([
            "content" => json_encode($request->terms_and_conditions)
        ]);

        $privacy_policy = StaticPage::where('key', "privacy-policy")->first();
        $privacy_policy->update([
            "content" => json_encode($request->privacy_policy)
        ]);

        $social_media = StaticPage::where('key', "social-media")->first();
        $social_media->update([
            "content" => json_encode($request->social_media)
        ]);

        $faq = StaticPage::where('key', "faq")->first();
        $faq->update([
            "content" => json_encode($request->faq)
        ]);

        return response()->json([
            "status" => true,
        ]);
    }
}
