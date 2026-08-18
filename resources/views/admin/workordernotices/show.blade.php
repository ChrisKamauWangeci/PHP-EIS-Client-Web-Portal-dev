<x-admin-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Workorder Notices</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('admin.workordernotices.index') }}" class="btn btn-sm btn-secondary">View Workorder Notices</a>
        </div>
    </div>

    <br />

    <table class="table table-bordered table-sm w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $workordernotice->id }}</td>
        </tr>
        <tr>
            <td>Workorder ID</td>
            <td>{{ $workordernotice->workorder_id }}</td>
        </tr>
        <tr>
            <td>User Before</td>
            <td>{{ $workordernotice->user_before }}</td>
        </tr>
        <tr>
            <td>User After</td>
            <td>{{ $workordernotice->user_after }}</td>
        </tr>
        <tr>
            <td>Sender</td>
            <td>{{ $workordernotice->sender }}</td>
        </tr>
        <tr>
            <td>Recipient</td>
            <td>{{ $workordernotice->recipient }}</td>
        </tr>
        <tr>
            <td>Subject</td>
            <td>{{ $workordernotice->subject }}</td>
        </tr>
        <tr>
            <td>Body</td>
            <td>{!! nl2br($workordernotice->body ?? '') !!}</td>
        </tr>
        <tr>
            <td>Emailed At</td>
            <td>{{ $workordernotice->emailed_at }}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $workordernotice->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $workordernotice->updated_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $workordernotice->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $workordernotice->updated_at }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('admin.workordernotices.edit', $workordernotice->id) }}" class="btn btn-sm btn-secondary">Edit</a>

    <br />

</x-admin-layout>