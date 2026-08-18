    <x-user-layout title="">

    <h1>Report Configs</h1>

    <br />
    <br />

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.report_configs.index') }}">

        <div class="row">

            <div class="col-md-2">
                <x-form.input name="report_name" id="report_name" label="Report Name" :value="request('report_name')" />
            </div>

            <div class="col-md-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.report_configs.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $reportConfigs->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Company</th>
                    <th>Report Type</th>
                    <th>Report Name</th>
                    <th>Report Schedule</th>
                    <th>Recipient Email</th>
                    <th>Destination Folder</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportConfigs as $reportConfig)
                    <tr>
                        <td>{{ $reportConfig->id }}</td>
                        <td>{{ $reportConfig->company }}</td>
                        <td>{{ $reportConfig->report_type }}</td>
                        <td>{{ $reportConfig->report_name }}</td>
                        <td>{{ $reportConfig->report_schedule }}</td>
                        <td>{{ $reportConfig->recipient_email }}</td>
                        <td>{{ $reportConfig->destination_folder }}</td>
                        <td>{{ $reportConfig->created_by }}</td>
                        <td>{{ $reportConfig->updated_by }}</td>
                        <td>{{ $reportConfig->created_at->format('m/d/Y g:i a') }}</td>
                        <td>{{ $reportConfig->updated_at->format('m/d/Y g:i a') }}</td>
                        <td>
                            <a href="{{ route('user.report_configs.show', $reportConfig->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $reportConfigs->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('user.report_configs.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

    <a href="{{ route('user.report_config_types.index') }}">Report Config Types</a>

    <br />
    <br />

    <a href="{{ route('user.report_config_names.index') }}">Report Config Names</a>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            reportConfig
            @php dump(@$reportConfig) @endphp
        </div>
    @endif

</x-user-layout>