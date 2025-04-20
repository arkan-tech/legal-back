<?php

namespace App\Services;

use Google\Service\SearchConsole;
use Google\Client;

class GoogleSearchConsoleService
{
	private $client;
	private $searchConsole;
	private $siteUrl;

	public function __construct()
	{
		$this->siteUrl = config('services.google.search_console.site_url');
		$this->client = new Client();
		$this->client->setAuthConfig(storage_path('app/google/search-console-credentials.json'));
		$this->client->addScope('https://www.googleapis.com/auth/webmasters.readonly');
		$this->searchConsole = new SearchConsole($this->client);
	}

	public function getSearchAnalytics($days = 30)
	{
		$endDate = date('Y-m-d');
		$startDate = date('Y-m-d', strtotime("-$days days"));

		try {
			$searchData = $this->searchConsole->searchanalytics->query($this->siteUrl, [
				'startDate' => $startDate,
				'endDate' => $endDate,
				'dimensions' => ['query', 'page', 'device', 'country'],
				'rowLimit' => 25,
			])->getRows();

			$data = [
				'total_clicks' => 0,
				'total_impressions' => 0,
				'average_ctr' => 0,
				'average_position' => 0,
				'top_queries' => [],
				'top_pages' => [],
				'devices' => [
					'DESKTOP' => ['clicks' => 0, 'impressions' => 0],
					'MOBILE' => ['clicks' => 0, 'impressions' => 0],
					'TABLET' => ['clicks' => 0, 'impressions' => 0],
				],
				'countries' => [],
			];

			if ($searchData) {
				foreach ($searchData as $row) {
					$data['total_clicks'] += $row->clicks;
					$data['total_impressions'] += $row->impressions;

					// Track by query
					if (!isset($data['top_queries'][$row->keys[0]])) {
						$data['top_queries'][$row->keys[0]] = [
							'clicks' => 0,
							'impressions' => 0,
							'ctr' => 0,
							'position' => 0,
						];
					}
					$data['top_queries'][$row->keys[0]]['clicks'] += $row->clicks;
					$data['top_queries'][$row->keys[0]]['impressions'] += $row->impressions;

					// Track by page
					if (!isset($data['top_pages'][$row->keys[1]])) {
						$data['top_pages'][$row->keys[1]] = [
							'clicks' => 0,
							'impressions' => 0,
							'ctr' => 0,
							'position' => 0,
						];
					}
					$data['top_pages'][$row->keys[1]]['clicks'] += $row->clicks;
					$data['top_pages'][$row->keys[1]]['impressions'] += $row->impressions;

					// Track by device
					$device = $row->keys[2];
					if (isset($data['devices'][$device])) {
						$data['devices'][$device]['clicks'] += $row->clicks;
						$data['devices'][$device]['impressions'] += $row->impressions;
					}

					// Track by country
					$country = $row->keys[3];
					if (!isset($data['countries'][$country])) {
						$data['countries'][$country] = [
							'clicks' => 0,
							'impressions' => 0,
						];
					}
					$data['countries'][$country]['clicks'] += $row->clicks;
					$data['countries'][$country]['impressions'] += $row->impressions;
				}

				// Calculate averages
				$data['average_ctr'] = $data['total_impressions'] > 0
					? round(($data['total_clicks'] / $data['total_impressions']) * 100, 2)
					: 0;

				// Sort and limit top queries and pages
				uasort($data['top_queries'], function ($a, $b) {
					return $b['clicks'] - $a['clicks'];
				});
				$data['top_queries'] = array_slice($data['top_queries'], 0, 10, true);

				uasort($data['top_pages'], function ($a, $b) {
					return $b['clicks'] - $a['clicks'];
				});
				$data['top_pages'] = array_slice($data['top_pages'], 0, 10, true);

				// Calculate CTR for each query and page
				foreach ($data['top_queries'] as &$query) {
					$query['ctr'] = $query['impressions'] > 0
						? round(($query['clicks'] / $query['impressions']) * 100, 2)
						: 0;
				}

				foreach ($data['top_pages'] as &$page) {
					$page['ctr'] = $page['impressions'] > 0
						? round(($page['clicks'] / $page['impressions']) * 100, 2)
						: 0;
				}

				// Calculate device CTRs
				foreach ($data['devices'] as $device => &$stats) {
					$stats['ctr'] = $stats['impressions'] > 0
						? round(($stats['clicks'] / $stats['impressions']) * 100, 2)
						: 0;
				}

				// Calculate country CTRs
				foreach ($data['countries'] as &$stats) {
					$stats['ctr'] = $stats['impressions'] > 0
						? round(($stats['clicks'] / $stats['impressions']) * 100, 2)
						: 0;
				}
			}

			return $data;
		} catch (\Exception $e) {
			\Log::error('Error fetching Search Console data: ' . $e->getMessage());
			return null;
		}
	}
}
