<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSearchConsoleService;
use Illuminate\Support\Facades\Log;

class GoogleSearchConsoleController extends Controller
{
	private $searchConsoleService;

	public function __construct(GoogleSearchConsoleService $searchConsoleService)
	{
		$this->searchConsoleService = $searchConsoleService;
	}

	public function getSearchData(Request $request)
	{
		try {
			$days = $request->query('days', 30);
			$searchData = $this->searchConsoleService->getSearchAnalytics($days);

			return response()->json($searchData);
		} catch (\Exception $e) {
			Log::error('Error fetching search console data: ' . $e->getMessage());
			return response()->json(['error' => 'Internal Server Error'], 500);
		}
	}
}
