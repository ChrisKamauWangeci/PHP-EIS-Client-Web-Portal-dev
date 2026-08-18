<x-email>

    Seqster Order Report

    <br />
    <br />

    <table class="table">
        <thead>
            <tr>
                <th>Workorder ID</th>
                <th>Company</th>
                <th>First Last Name</th>
                <th>Email</th>
                <th>API Error</th>
                <th>Visited At</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['seqsterorders'] as $seqsterorder)
            <tr>
                <td>{{ $seqsterorder->workorder_id }}</td>
                <td>{{ $seqsterorder->company }}</td>
                <td>{{ $seqsterorder->first_name }} {{ $seqsterorder->last_name }}</td>
                <td>{{ $seqsterorder->email }}</td>
                <td>{{ $seqsterorder->api_error }}</td>
                <td>{{ $seqsterorder->visited_at }}</td>
                <td>{{ $seqsterorder->status }}</td>
                <td>{{ $seqsterorder->created }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br />
    <br />

</x-email>