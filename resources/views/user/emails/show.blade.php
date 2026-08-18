<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Email</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.emails.index') }}" class="btn btn-sm btn-secondary">View Emails</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <th>Id</th>
            <td>{{ $email->id }}</td>
        </tr>
        <tr>
            <th>Workorder Id</th>
            <td>{{ $email->workorder_id }}</td>
        </tr>
        <tr>
            <th>Type</th>
            <td>{{ $email->type }}</td>
        </tr>
        <tr>
            <th>Contractor</th>
            <td>{{ $email->contractor }}</td>
        </tr>
        <tr>
            <th>Sender</th>
            <td>{{ $email->sender }}</td>
        </tr>
        <tr>
            <th>Recipient</th>
            <td>{{ $email->recipient }}</td>
        </tr>
        <tr>
            <th>Subject</th>
            <td>{{ $email->subject }}</td>
        </tr>
        <tr>
            <th>Message</th>
            <td>{!! nl2br($email->body) !!}</td>
        </tr>
        <tr>
            <th>Attachment</th>
            <td>{{ $email->attachment }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $email->created_at }}</td>
        </tr>
    </table>

    <br />
    <br />

</x-user-layout>