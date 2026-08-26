<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Report Config</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.report_configs.index') }}"
               class="btn btn-sm btn-secondary">View Report Configs</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">


        <tr>
            <td>ID</td>
            <td>{{ $reportConfig->id }}</td>
        </tr>
        <tr>
            <td>Company</td>
            <td>{{ $reportConfig->company }}</td>
        </tr>
        <tr>
            <td>Report Type</td>
            <td>{{ $reportConfig->report_type }}</td>
        </tr>
        <tr>
            <td>Report Name</td>
            <td>{{ $reportConfig->report_name }}</td>
        </tr>
        <tr>
            <td>Report Schedule</td>
            <td>{{ $reportConfig->report_schedule }}</td>
        </tr>
        <tr>
            <td>Recipient Email</td>
            <td>{{ $reportConfig->recipient_email }}</td>
        </tr>
        <tr>
            <td>Destination Folder</td>
            <td>{{ $reportConfig->destination_folder }}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $reportConfig->created_by }}</td>
        </tr>
        <tr>
            <td>Updated By</td>
            <td>{{ $reportConfig->updated_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $reportConfig->created_at->format('m/d/Y g:i a') }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $reportConfig->updated_at->format('m/d/Y g:i a') }}</td>
        </tr>
    </table>

    <br />

    <a href="{{ route('user.report_configs.edit', $reportConfig->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    <form method="POST"
          action="{{ route('user.report_configs.destroy', $reportConfig->id) }}">
        @csrf
        @method('DELETE')
        <x-form.button class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</x-form.button>
    </form>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            reportConfig
            @php dump(@$reportConfig) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
