<x-user-layout title="Daily Stats">

    <div class="row">
        <div class="col-auto">
            <h1>Daily Stats</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.daily_stats.index') }}" class="btn btn-sm btn-secondary">Daily Stats</a>
            <a href="{{ route('user.daily_stats.totals') }}" class="btn btn-sm btn-secondary">Daily Stats Totals</a>
        </div>
    </div>

    {{-- Date Range Filter --}}
    <form method="get" id="searchform" action="{{ route('user.daily_stats.index') }}">
        <div class="row">
            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="start" id="start" label="Start Date"
                    :value="request('start') ?? $start" type="date" autocomplete="off" min="2023-01-01" max="2030-01-01" />
            </div>
            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="end" id="end" label="End Date"
                    :value="request('end') ?? $end" type="date" autocomplete="off" min="2023-01-01" max="2030-01-01" />
            </div>
            <div class="col-md-2 pt-2">
                <label>&nbsp;</label><br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.daily_stats.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-window-close"></i></a>
            </div>
        </div>
    </form>

    <br />

    <div class="mb-2">
        <button type="button" class="btn btn-sm btn-secondary" onclick="showAll()">Select All</button>
        <button type="button" class="btn btn-sm btn-secondary" onclick="hideAll()">Unselect All</button>
    </div>

    <canvas id="dailyStatsChart" height="100"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @php
        $metricFields = ['aps_workorders_received', 'aps_workorders_completed', 'ehr_workorders_received', 'ehr_workorders_completed', 'ehr_orders_created', 'ehr_orders_submitted', 'ehr_orders_search_created', 'ehr_orders_search_submitted', 'ehr_documents_created', 'ehr_documents_received', 'eisweborders_created', 'seqster_orders_created', 'seqster_orders_visited', 'fax_created', 'fax_completed', 'docusign_created', 'docusign_completed', 'requestor_logins', 'contractor_logins'];

        $chartData = [];
        foreach ($metricFields as $field) {
            $chartData[$field] = $dailyStats->pluck($field)->toArray();
        }

        $dates = $dailyStats->pluck('metric_date')->map(fn($d) => $d->format('Y-m-d'))->toArray();
    @endphp

    <script>
        const ctx = document.getElementById('dailyStatsChart').getContext('2d');

        const metricFields = @json($metricFields);
        const colors = [
            'rgba(54, 162, 235, 1)', // blue
            'rgba(255, 99, 132, 1)', // red
            'rgba(153, 102, 255, 1)', // purple
            'rgba(255, 159, 64, 1)', // orange
            'rgba(75, 192, 192, 1)', // teal
            'rgba(255, 206, 86, 1)', // yellow
            'rgba(201, 203, 207, 1)', // gray
            'rgba(100, 149, 237, 1)', // cornflower blue
            'rgba(60, 179, 113, 1)', // green
            'rgba(199, 21, 133, 1)', // medium violet red
            'rgba(255, 140, 0, 1)', // dark orange
            'rgba(46, 139, 87, 1)', // sea green
            'rgba(106, 90, 205, 1)', // slate blue
            'rgba(220, 20, 60, 1)', // crimson
            'rgba(0, 191, 255, 1)', // deep sky blue
            'rgba(154, 205, 50, 1)', // yellow green
            'rgba(255, 20, 147, 1)', // deep pink
            'rgba(72, 61, 139, 1)', // dark slate blue
            'rgba(210, 105, 30, 1)' // chocolate
        ];

        const datasets = [];
        metricFields.forEach((field, index) => {
            datasets.push({
                label: field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()),
                data: @json($chartData)[field],
                borderColor: colors[index % colors.length],
                fill: false,
            });
        });

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: datasets
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                stacked: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Daily Metrics Overview'
                    }
                }
            }
        });

        function showAll() {
            chart.data.datasets.forEach((_, i) => {
                chart.setDatasetVisibility(i, true);
            });
            chart.update();
        }

        function hideAll() {
            chart.data.datasets.forEach((_, i) => {
                chart.setDatasetVisibility(i, false);
            });
            chart.update();
        }
    </script>

    <br />
    <br />

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>Date</th>
                    @foreach ($metricFields as $field)
                        <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($dailyStats as $stat)
                    <tr>
                        <td nowrap>{{ $stat->metric_date->format('Y-m-d') }}</td>
                        @foreach ($metricFields as $field)
                            <td>{{ $stat->$field }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-user-layout>
