<x-user-layout title="">

    <h1>Docusign Documents Stats</h1>

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
                @foreach ($docusigndocuments as $docusigndocument)
                    <tr>
                        <td>{{ $docusigndocument->year }}</td>
                        <td>{{ $docusigndocument->month }}</td>
                        <td>{{ $docusigndocument->counter }}</td>
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
                    @foreach($docusigndocuments as $docusigndocument)
                        "{{ $docusigndocument->year }} / {{ $docusigndocument->month }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Docusign Documents Stats',
                    data: [
                        @foreach($docusigndocuments as $docusigndocument)
                            {{ $docusigndocument->counter }},
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