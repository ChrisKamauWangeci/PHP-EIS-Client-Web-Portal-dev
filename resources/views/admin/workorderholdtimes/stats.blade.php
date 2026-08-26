<x-admin-layout title="">

    <h1>Workorder Hold Times Stats</h1>

    <br />

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workorderholdtimes as $workorderholdtime)
                    <tr>
                        <td>{{ $workorderholdtime->year }}</td>
                        <td>{{ $workorderholdtime->month }}</td>
                        <td>{{ $workorderholdtime->counter }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <canvas id="chart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($workorderholdtimes as $workorderholdtime)
                        "{{ $workorderholdtime->year }} / {{ $workorderholdtime->month }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Workorder Hold Times Stats',
                    data: [
                        @foreach ($workorderholdtimes as $workorderholdtime)
                            {{ $workorderholdtime->counter }},
                        @endforeach
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-admin-layout>
