<x-admin-layout title="">

    <h1>Platform Configurations</h1>

    <br />
    <br />

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('admin.platform-configurations.index') }}">
        <div class="row">
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="company" label="Company"  :options="$companies" empty="-" :default="request('company')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="platform" id="platform" label="Platform" :value="request('platform')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="order_type" id="order_type" label="Order Type" :value="request('order_type')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.platform-configurations.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <br />
    <br />

    {{ $platformConfigurations->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover1 table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}">Company</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'platform', 'sort_direction' => $sort_direction]) }}">Platform</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'order_type', 'sort_direction' => $sort_direction]) }}">Order Type</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'submission_type', 'sort_direction' => $sort_direction]) }}">Submission Type</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'wait_days', 'sort_direction' => $sort_direction]) }}">Wait Days</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'sequence', 'sort_direction' => $sort_direction]) }}">Sequence</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'is_active', 'sort_direction' => $sort_direction]) }}">Active</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($platformConfigurations as $platformConfiguration)
                    <tr>
                        <td>{{ $platformConfiguration->id }}</td>
                        <td>{{ $platformConfiguration->company }}</td>
                        <td>{{ $platformConfiguration->platform }}</td>
                        <td>{{ $platformConfiguration->order_type }}</td>
                        <td>{{ $platformConfiguration->submission_type }}</td>
                        <td>{{ $platformConfiguration->wait_days }}</td>
                        <td>{{ $platformConfiguration->sequence }}</td>
                        <td><img src="/img/icon_{{ $platformConfiguration->is_active }}.png" alt=""></td>
                        <td>{{ $platformConfiguration->created_at }}</td>
                        <td>{{ $platformConfiguration->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.platform-configurations.show', $platformConfiguration->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $platformConfigurations->withQueryString()->links() }}

    <br />

    <a href="{{ route('admin.platform-configurations.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

    <div hx-get="{{ route('admin.platform-configurations.create') }}" hx-swap="outerHTML" class="btn btn-sm btn-secondary">Add (HTMX)</div>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            platformConfigurations
            @php dump(@$platformConfigurations) @endphp
        </div>
    @endif

</x-admin-layout>