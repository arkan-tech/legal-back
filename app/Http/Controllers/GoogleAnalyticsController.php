<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleAnalyticsService;
use Illuminate\Support\Facades\Log;

class GoogleAnalyticsController extends Controller
{
    private $analyticsService;

    public function __construct(GoogleAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function getAnalyticsData(Request $request)
    {
        try {
            $days = $request->query('days', 30); // Default to 30 days if not specified
            $websiteAnalytics = $this->analyticsService->getWebsiteAnalytics($days);
            $mobileAnalytics = $this->analyticsService->getMobileAnalytics($days);

            return response()->json([
                'websiteAnalytics' => $websiteAnalytics,
                'mobileAnalytics' => $mobileAnalytics,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching analytics data: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
