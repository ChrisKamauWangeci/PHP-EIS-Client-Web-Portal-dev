<x-email>

    Fax Report

    <br />
    <br />

    <table class="table">
        <thead>
            <tr>
                <th>Work Order / Filename</th>
                <th>Applicant Name</th>
                <th>Fax Number</th>
                <th>Page Count</th>
                <th>Number of Attempts</th>
                <th>Total Transmit Time</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['faxes'] as $fax)
                <tr>
                    <td>{{ $fax->workorder }}</td>
                    <td>{{ $fax->applicant_name }}</td>
                    <td>{{ $fax->fax_number }}</td>
                    <td>{{ $fax->page_count }}</td>
                    <td>{{ $fax->number_of_attempts }}</td>
                    <td>{{ $fax->total_transmit_time }}</td>
                    <td>{{ $fax->api_status }}</td>
                    <td>{{ $fax->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br />
    <br />

</x-email>
