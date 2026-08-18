<x-user-layout title="Workorder Detail">

    <div class="row">
        <div class="col-auto">
            <h1>Workorder Detail</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorderdetails.index') }}" class="btn btn-sm btn-secondary">View Workorder Details</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $workorderdetail->id }}</td>
        </tr>
        <tr>
            <td>Workorder ID</td>
            <td>{{ $workorderdetail->workorder_id }}</td>
        </tr>
        <tr>
            <td>Requestor Role</td>
            <td>{{ $workorderdetail->requestorrole }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $workorderdetail->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $workorderdetail->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workorderdetail
            @php dump(@$workorderdetail) @endphp
        </div>
    @endif

</x-user-layout>
