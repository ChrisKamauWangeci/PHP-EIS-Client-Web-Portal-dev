<x-user-layout title="">

    <h1>Report Config Names</h1>

    <br />
    <br />

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.report_config_names.index') }}">

        <div class="row">

            <div class="col-md-2">
                <x-form.input name="report_name"
                              id="report_name"
                              label="report_name"
                              :value="request('report_name')" />
            </div>

            <div class="col-md-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.report_config_names.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $reportConfigNames->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>id</th>
                    <th>report_name</th>
                    <th>created_by</th>
                    <th>updated_by</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportConfigNames as $reportConfigName)
                    <tr>
                        <td>{{ $reportConfigName->id }}</td>
                        <td>{{ $reportConfigName->report_name }}</td>
                        <td>{{ $reportConfigName->created_by }}</td>
                        <td>{{ $reportConfigName->updated_by }}</td>
                        <td>{{ $reportConfigName->created_at->format('m/d/Y g:i a') }}</td>
                        <td>{{ $reportConfigName->updated_at->format('m/d/Y g:i a') }}</td>
                        <td>
                            <a href="{{ route('user.report_config_names.show', $reportConfigName->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $reportConfigNames->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('user.report_config_names.create') }}"
       class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            reportConfigName
            @php dump(@$reportConfigName) @endphp
        </div>
    @endif

</x-user-layout>
