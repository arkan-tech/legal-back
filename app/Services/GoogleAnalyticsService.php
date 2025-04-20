<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\FilterExpression;
use Google_Client;
use Google_Service_SearchConsole;
use Google_Service_SearchConsole_SearchAnalyticsQueryRequest;

class GoogleAnalyticsService
{
    private $client;
    private $propertyId;
    private $streams;
    private $searchConsoleClient;
    private $searchConsoleService;

    public function __construct()
    {
        $this->propertyId = config('services.google.analytics.property_id');
        $this->streams = config('services.google.analytics.streams');
        $this->client = new BetaAnalyticsDataClient([
            'credentials' => storage_path('app/google/analytics-credentials.json'),
        ]);

        // Initialize Search Console client
        $this->searchConsoleClient = new Google_Client();
        $this->searchConsoleClient->setAuthConfig(storage_path('app/google/analytics-credentials.json'));
        $this->searchConsoleClient->addScope('https://www.googleapis.com/auth/webmasters.readonly');
        $this->searchConsoleService = new Google_Service_SearchConsole($this->searchConsoleClient);
    }

    public function getSearchConsoleAnalytics($days = 30)
    {
        try {
            $site = config('services.google.search_console.site_url');
            $endDate = date('Y-m-d');
            $startDate = date('Y-m-d', strtotime("-$days days"));

            // Get query data
            $queryRequest = new Google_Service_SearchConsole_SearchAnalyticsQueryRequest();
            $queryRequest->setStartDate($startDate);
            $queryRequest->setEndDate($endDate);
            $queryRequest->setDimensions(['query']);
            $queryRequest->setRowLimit(10);
            $queryRequest->setSearchType('web');

            $queryResponse = $this->searchConsoleService->searchanalytics->query($site, $queryRequest);

            // Get device data
            $deviceRequest = new Google_Service_SearchConsole_SearchAnalyticsQueryRequest();
            $deviceRequest->setStartDate($startDate);
            $deviceRequest->setEndDate($endDate);
            $deviceRequest->setDimensions(['device']);
            $deviceRequest->setSearchType('web');

            $deviceResponse = $this->searchConsoleService->searchanalytics->query($site, $deviceRequest);

            $data = [
                'total_clicks' => 0,
                'total_impressions' => 0,
                'average_ctr' => 0,
                'average_position' => 0,
                'top_queries' => [],
                'devices' => [
                    'DESKTOP' => ['clicks' => 0, 'impressions' => 0, 'ctr' => 0],
                    'MOBILE' => ['clicks' => 0, 'impressions' => 0, 'ctr' => 0],
                    'TABLET' => ['clicks' => 0, 'impressions' => 0, 'ctr' => 0]
                ]
            ];

            if ($queryResponse->rows) {
                foreach ($queryResponse->rows as $row) {
                    $data['total_clicks'] += $row->clicks;
                    $data['total_impressions'] += $row->impressions;

                    // Store top queries
                    $data['top_queries'][] = [
                        'query' => $row->keys[0],
                        'clicks' => $row->clicks,
                        'impressions' => $row->impressions,
                        'ctr' => round($row->ctr * 100, 2),
                        'position' => round($row->position, 2)
                    ];
                }

                // Calculate averages
                if (count($queryResponse->rows) > 0) {
                    $data['average_ctr'] = round(($data['total_clicks'] / $data['total_impressions']) * 100, 2);
                    $totalPosition = array_sum(array_column($data['top_queries'], 'position'));
                    $data['average_position'] = round($totalPosition / count($queryResponse->rows), 2);
                }
            }

            // Process device data
            if ($deviceResponse->rows) {
                foreach ($deviceResponse->rows as $row) {
                    $device = strtoupper($row->keys[0]);
                    if (isset($data['devices'][$device])) {
                        $data['devices'][$device] = [
                            'clicks' => $row->clicks,
                            'impressions' => $row->impressions,
                            'ctr' => round($row->ctr * 100, 2)
                        ];
                    }
                }
            }

            return $data;
        } catch (\Exception $e) {
            \Log::error('Search Console Analytics Error: ' . $e->getMessage());
            return [
                'total_clicks' => 0,
                'total_impressions' => 0,
                'average_ctr' => 0,
                'average_position' => 0,
                'top_queries' => [],
                'devices' => [
                    'DESKTOP' => ['clicks' => 0, 'impressions' => 0, 'ctr' => 0],
                    'MOBILE' => ['clicks' => 0, 'impressions' => 0, 'ctr' => 0],
                    'TABLET' => ['clicks' => 0, 'impressions' => 0, 'ctr' => 0]
                ],
                'error' => $e->getMessage()
            ];
        }
    }

    public function getWebsiteAnalytics($days = 30)
    {
        if (!$this->propertyId || !isset($this->streams['web']) || !isset($this->streams['web']['stream_id'])) {
            return [];
        }

        $stringFilter = new StringFilter([
            'value' => $this->streams['web']['stream_id'],
            'match_type' => StringFilter\MatchType::EXACT,
        ]);

        $filter = new Filter([
            'field_name' => 'streamId',
            'string_filter' => $stringFilter,
        ]);

        $filterExpression = new FilterExpression([
            'filter' => $filter,
        ]);

        $response = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dateRanges' => [
                new DateRange([
                    'start_date' => $days . 'daysAgo',
                    'end_date' => 'today',
                ]),
            ],
            'dimensions' => [
                new Dimension(['name' => 'streamId']),
                new Dimension(['name' => 'platform']),
            ],
            'metrics' => [
                new Metric(['name' => 'activeUsers']),
                new Metric(['name' => 'screenPageViews']),
                new Metric(['name' => 'sessions']),
                new Metric(['name' => 'averageSessionDuration']),
                new Metric(['name' => 'bounceRate']),
            ],
            'dimensionFilter' => $filterExpression,
        ]);

        $data = [];
        foreach ($response->getRows() as $row) {
            $platform = $row->getDimensionValues()[1]->getValue();
            $metrics = $row->getMetricValues();

            $data[$platform] = [
                'active_users' => (int) $metrics[0]->getValue(),
                'page_views' => (int) $metrics[1]->getValue(),
                'sessions' => (int) $metrics[2]->getValue(),
                'avg_session_duration' => round((float) $metrics[3]->getValue(), 2),
                'bounce_rate' => round((float) $metrics[4]->getValue(), 2),
            ];
        }

        return $data;
    }

    public function getMobileAnalytics($days = 30)
    {
        $data = [
            'android' => [
                'active_users' => 0,
                'page_views' => 0,
                'sessions' => 0,
            ],
            'ios' => [
                'active_users' => 0,
                'page_views' => 0,
                'sessions' => 0,
            ],
        ];

        if (!$this->propertyId) {
            return $data;
        }

        foreach (['android', 'ios'] as $platform) {
            if (!isset($this->streams[$platform]) || !isset($this->streams[$platform]['app_id'])) {
                continue;
            }

            $stringFilter = new StringFilter([
                'value' => strtoupper($platform),
                'match_type' => StringFilter\MatchType::EXACT,
            ]);

            $filter = new Filter([
                'field_name' => 'platform',
                'string_filter' => $stringFilter,
            ]);

            $filterExpression = new FilterExpression([
                'filter' => $filter,
            ]);

            $response = $this->client->runReport([
                'property' => 'properties/' . $this->propertyId,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $days . 'daysAgo',
                        'end_date' => 'today',
                    ]),
                ],
                'dimensions' => [
                    new Dimension(['name' => 'platform']),
                    new Dimension(['name' => 'appVersion']),
                ],
                'metrics' => [
                    new Metric(['name' => 'activeUsers']),
                    new Metric(['name' => 'screenPageViews']),
                    new Metric(['name' => 'sessions']),
                ],
                'dimensionFilter' => $filterExpression,
            ]);

            if ($response->getRows()) {
                $metrics = $response->getRows()[0]->getMetricValues();
                $data[$platform] = [
                    'active_users' => (int) $metrics[0]->getValue(),
                    'page_views' => (int) $metrics[1]->getValue(),
                    'sessions' => (int) $metrics[2]->getValue(),
                ];
            }
        }

        return $data;
    }
}
