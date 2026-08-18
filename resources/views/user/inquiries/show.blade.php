<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Inquiry</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.inquiries.index') }}" class="btn btn-sm btn-secondary">View Inquiries</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $inquiry->id }}</td>
        </tr>
        <tr>
            <td>Account Manager</td>
            <td>{{ $inquiry->accountmanager }}</td>
        </tr>
        <tr>
            <td>Account Manager Email</td>
            <td>{{ $inquiry->accountmanageremail }}</td>
        </tr>
        <tr>
            <td>Company</td>
            <td>{{ $inquiry->company }}</td>
        </tr>
        <tr>
            <td>Requestor</td>
            <td>{{ $inquiry->requestor }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $inquiry->email }}</td>
        </tr>
        <tr>
            <td>Workorder</td>
            <td>{{ $inquiry->workorder }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $inquiry->name }}</td>
        </tr>
        <tr>
            <td>Message</td>
            <td>{{ $inquiry->message }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $inquiry->created_at }}</td>
        </tr>
        <tr>

    </table>

    <br />

    <!-- <a href="{{ route('user.inquiries.edit', $inquiry->id) }}" class="btn btn-sm btn-secondary">Edit</a> -->

    <br />
    <br />

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            inquiry
            @php dump(@$inquiry) @endphp
        </div>
    @endif

</x-user-layout>