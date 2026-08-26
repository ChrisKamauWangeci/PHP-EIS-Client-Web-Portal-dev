<x-email>

    <h1>Daily Stat Report</h1>

    <p>Period: {{ $startDate }} - {{ $endDate }}</p>

    <table border="1"
           cellpadding="5"
           cellspacing="0">
        <thead>
            <tr>
                <th>Metric</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($counts as $metric => $value)
                <tr>
                    <td>{{ ucwords(str_replace('_', ' ', $metric)) }}</td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-email>
