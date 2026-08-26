<x-user-layout title="Workorder Hold Time">

    <div class="row">
        <div class="col-auto">
            <h1>Workorder Hold Time</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorderholdtimes.index') }}"
               class="btn btn-sm btn-secondary">View Workorder Hold Times</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $workorderholdtime->id }}</td>
        </tr>
        <tr>
            <td>Company ID</td>
            <td>{{ $workorderholdtime->company_id }}</td>
        </tr>
        <tr>
            <td>Workorder ID</td>
            <td>{{ $workorderholdtime->workorder_id }}</td>
        </tr>
        <tr>
            <td>Hold ID</td>
            <td>{{ $workorderholdtime->hold_id }}</td>
        </tr>
        <tr>
            <td>Reason</td>
            <td>{{ $workorderholdtime->reason }}</td>
        </tr>
        <tr>
            <td>Requirement</td>
            <td>{{ $workorderholdtime->requirement }}</td>
        </tr>
        <tr>
            <td>Date Start</td>
            <td>{{ $workorderholdtime?->date_start?->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td>Date End</td>
            <td>{{ $workorderholdtime?->date_end?->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $workorderholdtime->created_by }}</td>
        </tr>
        <tr>
            <td>Modified By</td>
            <td>{{ $workorderholdtime->modified_by }}</td>
        </tr>
        <tr>
            <td>Created</td>
            <td>{{ $workorderholdtime->created }}</td>
        </tr>
        <tr>
            <td>Modified</td>
            <td>{{ $workorderholdtime->modified }}</td>
        </tr>
        <tr>
            <td>Image File</td>
            <td>{{ $workorderholdtime->image_file }}</td>
        </tr>
        <tr>
            <td>Status Code</td>
            <td>{{ $workorderholdtime->status_code }}</td>
        </tr>
        <tr>
            <td>Date Followup</td>
            <td>{{ $workorderholdtime->date_followup }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workorderholdtime
            @php dump(@$workorderholdtime) @endphp
        </div>
    @endif

</x-user-layout>
