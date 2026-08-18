<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Contractorlogin;
use App\Models\DailyStat;
use App\Models\Docusigndocument;
use App\Models\Ehrorder;
use App\Models\Ehrordersdocument;
use App\Models\Ehrorderssearchresult;
use App\Models\Ehrworkorder;
use App\Models\Eisweborder;
use App\Models\Fax;
use App\Models\Login;
use App\Models\Seqsterorder;
use App\Models\Workorder;
use Carbon\Carbon;

class DailyStatService
{
    /**
     * Get daily stats for a date range
     */
    public function getMetrics(?string $start = null, ?string $end = null)
    {
        $start = $start ?? Carbon::now()->subWeek()->toDateString();
        $end = $end ?? Carbon::now()->toDateString();

        return DailyStat::whereBetween('metric_date', [$start, $end])
            ->orderBy('metric_date')
            ->get();
    }

    /**
     * Record daily metrics (calculate + save)
     */
    public function recordDailyMetrics(?string $date = null)
    {
        $date = $date ?? now()->subDay()->toDateString();
        $metrics = $this->calculateCounts($date, $date);

        DailyStat::updateOrCreate(
            ['metric_date' => $date],
            $metrics
        );

        return $metrics;
    }

    /**
     * Calculate raw counts from source tables
     */
    public function calculateCounts(?string $start = null, ?string $end = null): array
    {
        $start = $start ?? now()->toDateString();
        $end = $end ?? now()->toDateString();

        $start = Carbon::parse($start)->startOfDay();
        $end = Carbon::parse($end)->addDay()->startOfDay();

        return [
            'aps_workorders_received' => Workorder::where('W_ReceiveDate', '>=', $start)->where('W_ReceiveDate', '<', $end)->count(),
            'aps_workorders_completed' => Workorder::where('W_CompletedDate', '>=', $start)->where('W_CompletedDate', '<', $end)->count(),

            'ehr_workorders_received' => Ehrworkorder::where('W_ReceiveDate', '>=', $start)->where('W_ReceiveDate', '<', $end)->count(),
            'ehr_workorders_completed' => Ehrworkorder::where('W_CompletedDate', '>=', $start)->where('W_CompletedDate', '<', $end)->count(),

            'ehr_orders_created' => Ehrorder::where('created_at', '>=', $start)->where('created_at', '<', $end)->count(),
            'ehr_orders_submitted' => Ehrorder::where('submitted_at', '>=', $start)->where('submitted_at', '<', $end)->count(),

            'ehr_orders_search_created' => Ehrorderssearchresult::where('created_at', '>=', $start)->where('created_at', '<', $end)->count(),
            'ehr_orders_search_submitted' => Ehrorderssearchresult::where('submitted_at', '>=', $start)->where('submitted_at', '<', $end)->count(),

            'ehr_documents_created' => Ehrordersdocument::where('created_at', '>=', $start)->where('created_at', '<', $end)->count(),
            'ehr_documents_received' => Ehrordersdocument::where('received_at', '>=', $start)->where('received_at', '<', $end)->count(),

            'eisweborders_created' => Eisweborder::where('created_at', '>=', $start)->where('created_at', '<', $end)->count(),

            'docusign_created' => Docusigndocument::where('created_at', '>=', $start)->where('created_at', '<', $end)->count(),
            'docusign_completed' => Docusigndocument::where('status', 'envelope-completed')->where('signed_at', '>=', $start)->where('signed_at', '<', $end)->count(),

            'fax_created' => Fax::where('created_at', '>=', $start)->where('created_at', '<', $end)->count(),
            'fax_completed' => Fax::where('api_status', 'Completed')->where('created_at', '>=', $start)->where('created_at', '<', $end)->count(),

            'seqster_orders_created' => Seqsterorder::where('created', '>=', $start)->where('created', '<', $end)->count(),
            'seqster_orders_visited' => Seqsterorder::where('visited_at', '>=', $start)->where('visited_at', '<', $end)->count(),

            'requestor_logins' => Login::where('created', '>=', $start)->where('created', '<', $end)->count(),
            'contractor_logins' => Contractorlogin::where('created_at', '>=', $start)->where('created_at', '<', $end)->count(),
        ];
    }
}
