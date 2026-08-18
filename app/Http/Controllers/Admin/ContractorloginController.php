<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contractorlogin;
use App\Models\Datachange;
use App\Models\Statustrigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContractorloginController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Contractorlogin::query()
            ->when($filters['contractor'] ?? null, fn ($q, $v) => $q->where('contractor', 'LIKE', "%{$v}%"))
            ->when($filters['ip_address'] ?? null, fn ($q, $v) => $q->where('ip_address', 'LIKE', "%{$v}%"))
            ->when($filters['from'] ?? null, fn ($q, $v) => $q->where('created_at', '>=', "{$v} 00:00:00"))
            ->when($filters['to'] ?? null, fn ($q, $v) => $q->where('created_at', '<=', "{$v} 23:59:59"));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $contractorlogins = $query->paginate(200);

        $contractors = Cache::remember('admin-contractorlogins-stats-' . $this->subdomain(), 60, function () {
            return Contractorlogin::query()
                ->select('contractor')
                ->distinct()
                ->orderBy('contractor', 'ASC')
                ->pluck('contractor', 'contractor')
                ->toArray();
        });

        return view('admin.contractorlogins.index', compact('contractorlogins', 'sort_direction', 'contractors'));
    }

    public function stats(Request $request)
    {
        $contractor = $request->query('contractor');
        $location = $request->query('location');
        $from = $request->query('from') ?? date('Y-m-d');
        $to = $request->query('to') ?? date('Y-m-d');
        $csv = $request->query('csv');
        $is_active = $request->query('is_active');

        $fromdate = new \DateTime($from);
        $todate = new \DateTime($to);

        $days_difference = $fromdate->diff($todate)->format('%R%a');

        if ($days_difference < 0) {
            return redirect()
                ->route('admin.contractorlogins.stats')
                ->with('danger', 'Invalid dates selected');
        }

        if ($days_difference > 100) {
            return redirect()
                ->route('admin.contractorlogins.stats')
                ->with('danger', 'Maximum 3 months of date difference allowed.');
        }

        $contractorlogins = Contractorlogin::query()
            ->select([
                'contractor_id',
                'contractor',
                'Contractor.C_Location as location',
                'Contractor.is_active as is_active',
                DB::raw('sum(uploads) as total_uploads'),
                DB::raw('sum(downloads) as total_downloads'),
                DB::raw('sum(page_views) as total_page_views'),
                DB::raw('sum(time_on_site) as total_time_on_site'),
                DB::raw('count(contractor_id) as login_count'),
                DB::raw('count(distinct(ip_address)) as ip_addresses'),
                DB::raw('min(created_at) as first_login'),
                DB::raw('max(updated_at) as last_activity'),
            ])
            ->leftJoin('Contractor', 'contractorlogins.contractor_id', '=', 'Contractor.id')
            ->when($contractor, fn ($q, $v) => $q->where('contractor', $v))
            ->when($is_active !== null, fn ($q) => $q->whereRaw('ISNULL(Contractor.is_active, 0) = ?', [(int) $is_active]))
            ->when($location, fn ($q, $v) => $q->where('Contractor.C_Location', $v))
            ->when($from, fn ($q, $v) => $q->where('created_at', '>=', $from . ' 00:00:00'))
            ->when($to, fn ($q, $v) => $q->where('created_at', '<=', $to . ' 23:59:59'))
            ->groupBy('contractor_id', 'contractor', 'Contractor.C_Location', 'Contractor.is_active')
            ->limit(500)
            ->get();

        $datachanges = Datachange::query()
            ->select([
                'created_by',
                DB::raw('count(created_by) as createdbycount'),
            ])
            ->when($contractor ?? null, fn ($q, $v) => $q->where('created_by', $contractor))
            ->when($from ?? null, fn ($q, $v) => $q->where('created_at', '>=', $from . ' 00:00:00'))
            ->when($to ?? null, fn ($q, $v) => $q->where('created_at', '<=', $to . ' 23:59:59'))
            ->groupBy('created_by')
            ->get();

        foreach ($contractorlogins as $contractorlogin) {
            $contractorlogin->datachanges_count = 0;
            foreach ($datachanges as $datachange) {
                if ($contractorlogin->contractor == $datachange->created_by) {
                    $contractorlogin->datachanges_count = $datachange->createdbycount;
                }
            }
        }

        $statustriggers = Statustrigger::query()
            ->select([
                'CreatedBy',
                DB::raw('count(CreatedBy) as createdbycount'),
            ])
            ->when($contractor ?? null, fn ($q, $v) => $q->where('CreatedBy', $contractor))
            ->when($from ?? null, fn ($q, $v) => $q->where('Created', '>=', $from . ' 00:00:00'))
            ->when($to ?? null, fn ($q, $v) => $q->where('Created', '<=', $to . ' 23:59:59'))
            ->groupBy('CreatedBy')
            ->get();

        foreach ($contractorlogins as $contractorlogin) {
            $contractorlogin->statustriggers_count = 0;
            foreach ($statustriggers as $statustrigger) {
                if ($contractorlogin->contractor == $statustrigger->CreatedBy) {
                    $contractorlogin->statustriggers_count = $statustrigger->createdbycount;
                }
            }
        }

        $contractors = Cache::remember('admin-contractorlogins-stats-' . $this->subdomain(), 60, function () {
            return Contractorlogin::query()
                ->select('contractor')
                ->distinct()
                ->orderBy('contractor', 'ASC')
                ->pluck('contractor', 'contractor')
                ->toArray();
        });

        if ($csv == 1) {

            $response = new StreamedResponse(function () use ($contractorlogins) {

                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Contractor',
                    'Location',
                    'Logins',
                    'IP Addresses',
                    'Uploads',
                    'Downloads',
                    'Data Changes',
                    'Status Triggers',
                    'Page Views',
                    'Time on Site',
                    'Time on Site',
                    'Avg Page View Time',
                    'First Login',
                    'Last Activity',
                ]);

                foreach ($contractorlogins as $contractorlogin) {

                    $totalTimeOnSite = 0;
                    if ($contractorlogin->total_time_on_site) {
                        $totalTimeOnSite = sprintf('%02d', floor($contractorlogin->total_time_on_site / 3600)) . gmdate(':i:s', $contractorlogin->total_time_on_site % 3600);
                    }

                    $avgPageViewTime = '0';
                    if ($contractorlogin->total_time_on_site && $contractorlogin->total_page_views) {
                        $avgPageViewTime = intval($contractorlogin->total_time_on_site / $contractorlogin->total_page_views) ?? '0';
                    }

                    fputcsv($handle, [
                        $contractorlogin->contractor,
                        $contractorlogin->location,
                        $contractorlogin->login_count,
                        $contractorlogin->ip_addresses,
                        $contractorlogin->total_uploads,
                        $contractorlogin->total_downloads,
                        $contractorlogin->datachanges_count,
                        $contractorlogin->statustriggers_count,
                        $contractorlogin->total_page_views,
                        $contractorlogin->total_time_on_site,
                        $totalTimeOnSite,
                        $avgPageViewTime,
                        $contractorlogin->first_login->format('m/d/Y g:i a'),
                        $contractorlogin->last_activity->format('m/d/Y g:i a'),
                    ]);
                }
                fclose($handle);
            });
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', "attachment; filename=contractors_stats_{$from}_{$to}.csv");

            return $response;
        }

        return view('admin.contractorlogins.stats', compact('contractorlogins', 'contractors', 'from', 'to'));
    }

    public function statsdaily(Request $request)
    {
        $contractor = $request->query('contractor');
        $location = $request->query('location');
        $from = $request->query('from') ?? date('Y-m-d');
        $to = $request->query('to') ?? date('Y-m-d');
        $is_active = $request->query('is_active');
        $csv_stats = $request->query('csv_stats');
        $csv_summary = $request->query('csv_summary');

        $contractorlogins = Contractorlogin::query()
            ->select([
                'contractor_id',
                'contractor',
                'Contractor.C_Location as location',
                'Contractor.is_active as is_active',
                DB::raw('CAST(created_at AS DATE) as login_date'),
                DB::raw('COUNT(*) as total_logins'),
                DB::raw('SUM(uploads) as total_uploads'),
                DB::raw('SUM(downloads) as total_downloads'),
                DB::raw('count(contractor_id) as login_count'),
                DB::raw('count(distinct(ip_address)) as ip_addresses'),
                DB::raw('SUM(page_views) as total_page_views'),
                DB::raw('SUM(time_on_site) as total_time_on_site'),
                DB::raw('min(created_at) as first_login'),
                DB::raw('max(updated_at) as last_activity'),
            ])
            ->leftJoin('Contractor', 'contractorlogins.contractor_id', '=', 'Contractor.id')
            ->when($contractor ?? null, fn ($q, $v) => $q->where('contractor', $contractor))

            ->when($location ?? null, fn ($q, $v) => $q->where('Contractor.C_Location', $v))
            ->when($from ?? null, fn ($q, $v) => $q->where('created_at', '>=', $from . ' 00:00:00'))
            ->when($to ?? null, fn ($q, $v) => $q->where('created_at', '<=', $to . ' 23:59:59'))
            ->groupBy(
                'contractor',
                'contractor_id',
                'Contractor.C_Location',
                'Contractor.is_active',
                DB::raw('CAST(created_at AS DATE)')
            )
            ->orderBy('login_date', 'desc')
            ->get();

        $eightHours = 8 * 3600;

        $totals = [
            'logins' => 0,
            'uploads' => 0,
            'downloads' => 0,
            'page_views' => 0,
            'time' => 0,
            'regular_time' => 0,
            'over_time' => 0,
        ];

        $contractorlogins = $contractorlogins->map(function ($row) use ($eightHours, &$totals) {

            $totalSeconds = (int) $row->total_time_on_site;

            $regularSeconds = min($totalSeconds, $eightHours);
            $overSeconds = max(0, $totalSeconds - $eightHours);

            $row->formatted_time = sprintf(
                '%02d%s',
                floor($totalSeconds / 3600),
                gmdate(':i:s', $totalSeconds % 3600)
            );

            $row->regular_seconds = $regularSeconds;
            $row->overtime_seconds = $overSeconds;

            $row->regular_time = sprintf(
                '%02d%s',
                floor($regularSeconds / 3600),
                gmdate(':i:s', $regularSeconds % 3600)
            );

            $row->overtime_time = $overSeconds
                ? sprintf(
                    '%02d%s',
                    floor($overSeconds / 3600),
                    gmdate(':i:s', $overSeconds % 3600)
                )
                : null;

            $row->avg_page_view_time = ((int) $row->total_page_views > 0)
                ? intdiv((int) $totalSeconds, (int) $row->total_page_views)
                : null;

            $totals['logins'] += $row->login_count;
            $totals['uploads'] += $row->total_uploads;
            $totals['downloads'] += $row->total_downloads;
            $totals['page_views'] += $row->total_page_views;
            $totals['time'] += $totalSeconds;
            $totals['regular_time'] += $regularSeconds;
            $totals['over_time'] += $overSeconds;

            return $row;
        });

        // dump($contractorlogins);

        $contractors = Cache::remember('admin-contractorlogins-stats-' . $this->subdomain(), 60, function () {
            return Contractorlogin::query()
                ->select('contractor')
                ->distinct()
                ->orderBy('contractor', 'ASC')
                ->pluck('contractor', 'contractor')
                ->toArray();
        });

        $contractorSummaries = [];

        foreach ($contractorlogins as $contractorlogin) {
            $contractor = $contractorlogin->contractor;

            if (! isset($contractorSummaries[$contractor])) {
                $contractorSummaries[$contractor] = [
                    'total_time' => 0,
                    'regular_time' => 0,
                    'overtime' => 0,
                    'days' => 0,
                ];
            }

            $totalSeconds = $contractorlogin->total_time_on_site;
            $eightHours = 8 * 3600;

            $contractorSummaries[$contractor]['contractor'] = $contractor;
            $contractorSummaries[$contractor]['total_time'] += $totalSeconds;
            $contractorSummaries[$contractor]['regular_time'] += min($totalSeconds, $eightHours);
            $contractorSummaries[$contractor]['overtime'] += max(0, $totalSeconds - $eightHours);
            $contractorSummaries[$contractor]['days']++;
        }

        ksort($contractorSummaries);

        // dump($contractorSummaries);

        if ($csv_stats == 1) {

            $response = new StreamedResponse(function () use ($contractorlogins, $totals) {

                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Contractor',
                    'Location',
                    'Logins',
                    'Login Date',
                    'IP Addresses',
                    'Uploads',
                    'Downloads',
                    'Page Views',
                    'Time on Site',
                    'Time on Site',
                    'Regular Time',
                    'Over Time',
                    'Avg Page View Time',
                    'First Login',
                    'Last Activity',
                ]);

                foreach ($contractorlogins as $contractorlogin) {

                    $avgPageViewTime = '0';
                    if ($contractorlogin->total_time_on_site && $contractorlogin->total_page_views) {
                        $avgPageViewTime = intval($contractorlogin->total_time_on_site / $contractorlogin->total_page_views) ?? '0';
                    }

                    fputcsv($handle, [
                        $contractorlogin->contractor,
                        $contractorlogin->location,
                        $contractorlogin->login_count,
                        $contractorlogin->login_date->format('m/d/Y'),
                        $contractorlogin->ip_addresses,
                        $contractorlogin->total_uploads,
                        $contractorlogin->total_downloads,
                        $contractorlogin->total_page_views,
                        $contractorlogin->total_time_on_site,
                        $contractorlogin->formatted_time,
                        $contractorlogin->regular_time,
                        $contractorlogin->overtime_time ?? 0,
                        $avgPageViewTime,
                        $contractorlogin->first_login->format('m/d/Y g:i a'),
                        $contractorlogin->last_activity->format('m/d/Y g:i a'),
                    ]);
                }

                fputcsv($handle, [
                    $contractorlogins->count(),
                    '',
                    '',
                    $totals['logins'],
                    '',
                    $totals['uploads'],
                    $totals['downloads'],
                    $totals['page_views'],
                    $totals['time'],
                    sprintf('%02d', floor($totals['time'] / 3600)) . gmdate(':i:s', $totals['time'] % 3600),
                    '',
                    '',
                    '',
                ]);

                fclose($handle);
            });
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', "attachment; filename=contractor_stats_{$from}_{$to}.csv");

            return $response;
        }

        if ($csv_summary == 1) {

            $response = new StreamedResponse(function () use ($contractorSummaries, $totals, $from, $to) {

                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Contractor',
                    'Days',
                    'Total Hours',
                    'Regular Time',
                    'Overtime',
                ]);

                foreach ($contractorSummaries as $contractorSummary) {

                    fputcsv($handle, [
                        $contractorSummary['contractor'],
                        $contractorSummary['days'],
                        sprintf('%02d', floor($contractorSummary['total_time'] / 3600)) . gmdate(':i:s', $contractorSummary['total_time'] % 3600),
                        sprintf('%02d', floor($contractorSummary['regular_time'] / 3600)) . gmdate(':i:s', $contractorSummary['regular_time'] % 3600),
                        $contractorSummary['overtime'] > 0 ? sprintf('%02d', floor($contractorSummary['overtime'] / 3600)) . gmdate(':i:s', $contractorSummary['overtime'] % 3600) : '0',
                    ]);
                }

                fputcsv($handle, [
                    count($contractorSummaries),
                    array_sum(array_column($contractorSummaries, 'days')),
                    sprintf('%02d', floor($totals['time'] / 3600)) . gmdate(':i:s', $totals['time'] % 3600),
                    sprintf('%02d', floor($totals['regular_time'] / 3600)) . gmdate(':i:s', $totals['regular_time'] % 3600),
                    sprintf('%02d', floor($totals['over_time'] / 3600)) . gmdate(':i:s', $totals['over_time'] % 3600),
                ]);

                fputcsv($handle, [
                    'Date: ' . $from . ' - ' . $to,
                ]);

                fclose($handle);
            });
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', "attachment; filename=contractor_summary_{$from}_{$to}.csv");

            return $response;
        }

        return view('admin.contractorlogins.statsdaily', compact('contractorlogins', 'totals', 'contractorSummaries', 'contractors', 'from', 'to'));
    }
}
