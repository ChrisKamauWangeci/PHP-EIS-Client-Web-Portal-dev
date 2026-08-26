<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>File Transfer</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('user.filetransfers.index') }}"
               class="btn btn-sm btn-secondary">View File Transfers</a>
        </div>
    </div>

    <br />

    <table class="table table-bordered table-sm w-auto">
        <tr>
            <td>Direction</td>
            <td>{{ $filetransfer->direction }}</td>
        </tr>
        <tr>
            <td>File Type</td>
            <td>{{ $filetransfer->file_type }}</td>
        </tr>
        <tr>
            <td>Filename</td>
            <td>{{ $filetransfer->filename }}</td>
        </tr>
        <tr>
            <td>Workorder ID</td>
            <td><a
                   href="{{ route('user.workorders.show', $filetransfer->workorder_id) }}">{{ $filetransfer->workorder_id }}</a>
            </td>
        </tr>
        <tr>
            <td>Contractor ID</td>
            <td>{{ $filetransfer->contractor_id }}</td>
        </tr>
        <tr>
            <td>Contractor</td>
            <td>{{ $filetransfer->contractor }}</td>
        </tr>
        <tr>
            <td>IP Address</td>
            <td>{{ $filetransfer->ip_address }}</td>
        </tr>
        <tr>
            <td>Remote Host</td>
            <td>{{ $filetransfer->remote_host }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $filetransfer->created_at }}</td>
        </tr>
    </table>

    <br />
    <br />

</x-user-layout>
