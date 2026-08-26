<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Workorder Notice</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workordernotices.index') }}"
               class="btn btn-sm btn-secondary">View Workorder Notices</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <th>Id</th>
            <td>{{ $workordernotice->id }}</td>
        </tr>
        <tr>
            <th>Workorder Id</th>
            <td>{{ $workordernotice->workorder_id }}</td>
        </tr>
        <tr>
            <th>User Before</th>
            <td>{{ $workordernotice->user_before }}</td>
        </tr>
        <tr>
            <th>User After</th>
            <td>{{ $workordernotice->user_after }}</td>
        </tr>
        <tr>
            <th>Type</th>
            <td>{{ $workordernotice->type }}</td>
        </tr>
        <tr>
            <th>Sender</th>
            <td>{{ $workordernotice->sender }}</td>
        </tr>
        <tr>
            <th>Recipient</th>
            <td>{{ $workordernotice->recipient }}</td>
        </tr>
        <tr>
            <th>Subject</th>
            <td>{{ $workordernotice->subject }}</td>
        </tr>
        <tr>
            <th>Message</th>
            <td>{!! nl2br($workordernotice->body) !!}</td>
        </tr>
        <tr>
            <th>Attachment</th>
            <td>
                <a href="/user/files?file={{ $workordernotice->attachment }}&amp;download=0"
                   target="_blank">{{ basename($workordernotice->attachment) }}</a>
            </td>
        </tr>
        <tr>
            <th>Created By</th>
            <td>{{ $workordernotice->created_by }}</td>
        </tr>
        <tr>
            <th>Updated By</th>
            <td>{{ $workordernotice->updated_by }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $workordernotice->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $workordernotice->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workordernotice
            @php dump(@$workordernotice) @endphp
        </div>
    @endif

</x-user-layout>
