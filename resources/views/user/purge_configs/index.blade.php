<x-user-layout title="">

    <h1>Purge Configs</h1>

    <br />
    <br />

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.purge_configs.index') }}">

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="company_name" id="company_name" label="Company Name" :value="request('company_name')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.purge_configs.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $purgeConfigs->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'company_name', 'sort_direction' => $sort_direction]) }}">Company Name</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'folder_name', 'sort_direction' => $sort_direction]) }}">Folder Name</a></th>
                    <th>
                        Source Path
                        <br />
                        Destination Path
                    </th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'frequency', 'sort_direction' => $sort_direction]) }}">Frequency</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'purge_after_days', 'sort_direction' => $sort_direction]) }}">Purge After Days</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'purge_type', 'sort_direction' => $sort_direction]) }}">Purge Type</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'last_purge_date', 'sort_direction' => $sort_direction]) }}">Last Purge Date</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purgeConfigs as $purgeConfig)
                    <tr>
                        <td>{{ $purgeConfig->company_name }}</td>
                        <td>{{ $purgeConfig->folder_name }}</td>
                        <td>
                            {{ $purgeConfig->source_path }}
                            <br />
                            {{ $purgeConfig->destination_path }}
                        </td>
                        <td>{{ $purgeConfig->frequency }}</td>
                        <td>{{ $purgeConfig->purge_after_days }}</td>
                        <td>{{ $purgeConfig->purge_type }}</td>
                        <td>{{ $purgeConfig->last_purge_date }}</td>
                        <td>{{ $purgeConfig->created_at }}</td>
                        <td>
                            <a href="{{ route('user.purge_configs.show', $purgeConfig->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $purgeConfigs->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('user.purge_configs.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            purgeConfigs
            @php dump(@$purgeConfigs) @endphp
        </div>
    @endif

</x-user-layout>