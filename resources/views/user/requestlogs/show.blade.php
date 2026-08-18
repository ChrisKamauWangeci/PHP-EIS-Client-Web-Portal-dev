<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Request Log</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.requestlogs.index') }}" class="btn btn-sm btn-secondary">View Request Logs</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>id</td>
            <td>{{ $requestlog->id }}</td>
        </tr>
        <tr>
            <th>workorder_id</th>
            <td>{{ $requestlog->workorder_id }}</td>
        </tr>
        <tr>
            <th>request_type</th>
            <td>{{ $requestlog->request_type }}</td>
        </tr>
        <tr>
            <th>notes</th>
            <td>{{ $requestlog->notes }}</td>
        </tr>
        <tr>
            <th>status</th>
            <td>{{ $requestlog->status }}</td>
        </tr>
        <tr>
            <th>created by</th>
            <td>{{ $requestlog->created_by }}</td>
        </tr>
        <tr>
            <th>updated by</th>
            <td>{{ $requestlog->updated_by }}</td>
        </tr>
        <tr>
            <th>created at</th>
            <td>{{ $requestlog->created_at }}</td>
        </tr>
        <tr>
            <th>updated at</th>
            <td>{{ $requestlog->updated_at }}</td>
        </tr>

    </table>

    <br />

    <a href="{{ route('user.requestlogs.edit', $requestlog->id) }}" class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            requestlog
            @php dump(@$requestlog) @endphp
        </div>
    @endif

</x-user-layout>