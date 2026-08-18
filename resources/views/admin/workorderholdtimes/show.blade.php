<x-admin-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Workorder Hold Time</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('admin.workorderholdtimes.index') }}" class="btn btn-sm btn-secondary">View Workorder Hold Times</a>
        </div>
    </div>

    <br />

    <table class="table table-bordered table-sm w-auto">
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
            <td>Contractor</td>
            <td>{{ $workorderholdtime->contractor }}</td>
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
            <td>{{ $workorderholdtime->date_start }}</td>
        </tr>
        <tr>
            <td>Date End</td>
            <td>{{ $workorderholdtime->date_end }}</td>
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
    </table>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workorderholdtime
            @php dump(@$workorderholdtime) @endphp
        </div>
    @endif

    <br />
    <br />

</x-admin-layout>