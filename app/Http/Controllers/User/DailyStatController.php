<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\DailyStatService;
use Illuminate\Http\Request;

class DailyStatController extends Controller
{
    public function index(Request $request, DailyStatService $dailyStatService)
    {
        $start = $request->query('start') ?? now()->subMonth()->toDateString();
        $end = $request->query('end') ?? now()->toDateString();

        $dailyStats = $dailyStatService->getMetrics($start, $end) ?? collect();

        $metricFields = [
            'aps_workorders_received',
            'aps_workorders_completed',
            'ehr_workorders_received',
            'ehr_workorders_completed',
            'ehr_orders_created',
            'ehr_orders_submitted',
            'ehr_orders_search_created',
            'ehr_orders_search_submitted',
            'ehr_documents_created',
            'ehr_documents_received',
            'eisweborders_created',
            'seqster_orders_created',
            'seqster_orders_visited',
            'fax_created',
            'fax_completed',
            'docusign_created',
            'docusign_completed',
            'requestor_logins',
            'contractor_logins',
        ];

        $metricsData = [];
        foreach ($metricFields as $field) {
            $metricsData[$field] = $dailyStats->pluck($field)->toArray(); // safe array
        }

        return view('user.daily_stats.index', array_merge([
            'start' => $start,
            'end' => $end,
            'dailyStats' => $dailyStats,
            'dates' => $dailyStats->pluck('metric_date')->map(fn ($d) => $d->format('Y-m-d'))->toArray(),
        ], $metricsData));
    }

    public function totals(Request $request, DailyStatService $dailyStatService)
    {
        $start = $request->query('start') ? $request->query('start') : now()->toDateString();
        $end = $request->query('end') ? $request->query('end') : now()->toDateString();

        $dailyStats = $dailyStatService->calculateCounts($start, $end);

        extract($dailyStats);

        return view('user.daily_stats.totals', compact(
            'start',
            'end',
            'aps_workorders_received',
            'aps_workorders_completed',
            'ehr_workorders_received',
            'ehr_workorders_completed',
            'ehr_orders_created',
            'ehr_orders_submitted',
            'ehr_orders_search_created',
            'ehr_orders_search_submitted',
            'ehr_documents_created',
            'ehr_documents_received',
            'eisweborders_created',
            'seqster_orders_created',
            'seqster_orders_visited',
            'fax_created',
            'fax_completed',
            'docusign_created',
            'docusign_completed',
            'requestor_logins',
            'contractor_logins',
        ));
    }
}
