<?php

namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use App\Models\Service;
use App\Traits\HandlesWidgetErrors;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServicePopularityWidget extends ChartWidget
{
    use HandlesWidgetErrors;

    protected static ?int $sort = 3;

    protected ?string $heading = 'Service Request Distribution';

    protected ?string $description = 'Most requested services in the last 30 days';

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    public function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        return $this->measureOperation('getServicePopularityData', function () {
            return $this->getCachedStat('service_popularity', function () {
                $startDate = Carbon::now()->subDays(30);

                // Get service request counts from contact submissions with error handling
                $serviceRequests = $this->safeQuery(function () use ($startDate) {
                    return ContactSubmission::where('created_at', '>=', $startDate)
                        ->whereNotNull('service')
                        ->select('service', DB::raw('count(*) as count'))
                        ->groupBy('service')
                        ->orderByDesc('count')
                        ->limit(10)
                        ->get();
                }, null, 0, collect());

                $labels = [];
                $data = [];
                $backgroundColors = [];

                if ($serviceRequests && $serviceRequests->isNotEmpty()) {
                    foreach ($serviceRequests as $request) {
                        // Format service name for display
                        $serviceName = $this->formatServiceName($request->service);
                        $labels[] = $serviceName;
                        $data[] = $request->count;

                        // Assign colors based on service type
                        $backgroundColors[] = $this->getServiceColor($request->service);
                    }
                }

                // If no data, show placeholder
                if (empty($data)) {
                    $labels = ['No requests yet'];
                    $data = [0];
                    $backgroundColors = ['#9CA3AF'];
                }

                return [
                    'datasets' => [
                        [
                            'label' => 'Service Requests',
                            'data' => $data,
                            'backgroundColor' => $backgroundColors,
                            'borderColor' => $backgroundColors,
                            'borderWidth' => 1,
                        ],
                    ],
                    'labels' => $labels,
                ];
            }, 1800); // Cache for 30 minutes since this data changes less frequently
        });
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) {
                            return context.parsed.y + ' requests';
                        }",
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                    ],
                    'grid' => [
                        'display' => true,
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'autoSkip' => false,
                        'maxRotation' => 45,
                        'minRotation' => 45,
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
            'responsive' => true,
        ];
    }

    protected function formatServiceName(string $service): string
    {
        // Handle common service names
        $serviceMap = [
            'request-callback' => 'Callback Request',
            'pool-resurfacing-conversion' => 'Pool Resurfacing',
            'pool-repair' => 'Pool Repair',
            'pool-remodeling' => 'Pool Remodeling',
            'tile-replacement' => 'Tile Replacement',
            'coping-installation' => 'Coping Installation',
            'gelcoat-refinishing' => 'Gelcoat Refinishing',
            'newsletter' => 'Newsletter',
            'general_inquiry' => 'General Inquiry',
            'franchise' => 'Franchise Inquiry',
            'partnership' => 'Partnership',
            'capital_investment' => 'Investment',
        ];

        if (isset($serviceMap[$service])) {
            return $serviceMap[$service];
        }

        // Format unknown services
        return ucwords(str_replace(['_', '-'], ' ', $service));
    }

    protected function getServiceColor(string $service): string
    {
        // Assign consistent colors to service types
        $colorMap = [
            'request-callback' => '#10B981',        // Green
            'pool-resurfacing-conversion' => '#3B82F6', // Blue
            'pool-repair' => '#EF4444',             // Red
            'pool-remodeling' => '#8B5CF6',         // Purple
            'tile-replacement' => '#F59E0B',        // Amber
            'coping-installation' => '#EC4899',      // Pink
            'gelcoat-refinishing' => '#14B8A6',     // Teal
            'newsletter' => '#22C55E',              // Green
            'general_inquiry' => '#6B7280',         // Gray
            'franchise' => '#F97316',               // Orange
            'partnership' => '#0EA5E9',             // Sky
            'capital_investment' => '#84CC16',      // Lime
        ];

        return $colorMap[$service] ?? '#9CA3AF'; // Default gray
    }
}