<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Cancellation Request</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.apscancellations.index') }}"
               class="btn btn-sm btn-secondary">View Cancellation Requests</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>Cancellation ID</td>
            <td>{{ $apscancellation->CancellationID }}</td>
        </tr>
        <tr>
            <td>WorkOrder ID</td>
            <td>{{ $apscancellation->EISWorkOrderID }}</td>
        </tr>
        <tr>
            <td>Request ID</td>
            <td>{{ $apscancellation->RequestID }}</td>
        </tr>
        <tr>
            <td>Company ID</td>
            <td>{{ $apscancellation->CompanyID }}</td>
        </tr>
        <tr>
            <td>Company Name</td>
            <td>{{ $apscancellation->CompanyName }}</td>
        </tr>
        <tr>
            <td>Cancellation Status ID</td>
            <td>{{ $apscancellation->CancellationStatusID }}</td>
        </tr>
        <tr>
            <td>Cancellation Status</td>
            <td>{{ $cancellationStatusOptions[$apscancellation->CancellationStatusID] ?? '' }}</td>
        </tr>
        <tr>
            <td>Is Completed</td>
            <td>{{ $apscancellation->IsNotified ? 'Yes' : 'No' }}</td>
        </tr>
        <tr>
            <td>User Name</td>
            <td>{{ $apscancellation->Username }}</td>
        </tr>
        <tr>
            <td>Requested Date</td>
            <td>{{ $apscancellation->Inserted }}</td>
        </tr>
        <tr>
            <td>Updated Date</td>
            <td>{{ $apscancellation->Updated }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('user.apscancellations.edit', $apscancellation->CancellationID) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            apscancellation
            @php dump(@$apscancellation) @endphp
        </div>
    @endif

</x-user-layout>
