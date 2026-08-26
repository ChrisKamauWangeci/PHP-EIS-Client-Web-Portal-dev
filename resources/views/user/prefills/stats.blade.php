<x-user-layout title="">

    <h1>In House Prefills Stats</h1>

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
                @foreach ($prefills as $prefill)
                    <tr>
                        <td>{{ $prefill->year }}</td>
                        <td>{{ $prefill->month }}</td>
                        <td>{{ $prefill->counter }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <canvas id="chart"></canvas>
    </div>

    <br />
    <br />

    <h1>In House Prefills Most Used Forms</h1>

    @php
        $i = 0;
    @endphp

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>slug</th>
                    <th>orders</th>
                    <th>form</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prefillforms as $prefillform)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $prefillform->slug }}</td>
                        <td>{{ $prefillform->counter }}</td>
                        <td>
                            <a
                               href="/user/files?file=\\ftpserver\ftpserver\facilityformsfillable\{{ $prefillform->slug }}.pdf&download=1">{{ $prefillform->slug }}.pdf</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($prefills as $prefill)
                        "{{ $prefill->year }} / {{ $prefill->month }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Docusign Documents Stats',
                    data: [
                        @foreach ($prefills as $prefill)
                            {{ $prefill->counter }},
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
