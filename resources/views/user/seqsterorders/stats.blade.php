<x-user-layout title="">

    <h1>Seqster Orders Stats</h1>

    <br />

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Orders</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seqsterorders as $seqsterorder)
                    <tr>
                        <td>{{ $seqsterorder->year }}</td>
                        <td>{{ $seqsterorder->month }}</td>
                        <td>{{ $seqsterorder->counter }}</td>
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
                    @foreach ($seqsterorders as $seqsterorder)
                        "{{ $seqsterorder->year }} / {{ $seqsterorder->month }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Seqster Orders Stats',
                    data: [
                        @foreach ($seqsterorders as $seqsterorder)
                            {{ $seqsterorder->counter }},
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

</x-user-layout>
