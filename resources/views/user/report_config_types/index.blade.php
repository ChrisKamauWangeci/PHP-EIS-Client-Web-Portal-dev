<x-user-layout title="">

    <h1>Report Config Types</h1>

    <br />
    <br />

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.report_config_types.index') }}">

        <div class="row">

            <div class="col-md-2">
                <x-form.input name="report_type" id="report_type" label="Report Type" :value="request('report_type')" />
            </div>

            <div class="col-md-2">
                <br />
                <x-form.button type="submit">Submit</x-form.button>
                <a href="{{ route('user.report_config_types.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $reportConfigTypes->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Report Type</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportConfigTypes as $reportConfigType)
                    <tr>
                        <td>{{ $reportConfigType->id }}</td>
                        <td>{{ $reportConfigType->report_type }}</td>
                        <td>{{ $reportConfigType->created_by }}</td>
                        <td>{{ $reportConfigType->updated_by }}</td>
                        <td>{{ $reportConfigType->created_at->format('m/d/Y g:i a') }}</td>
                        <td>{{ $reportConfigType->updated_at->format('m/d/Y g:i a') }}</td>
                        <td>
                            <a href="{{ route('user.report_config_types.show', $reportConfigType->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $reportConfigTypes->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('user.report_config_types.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            reportConfigType
            @php dump(@$reportConfigType) @endphp
        </div>
    @endif

</x-user-layout>