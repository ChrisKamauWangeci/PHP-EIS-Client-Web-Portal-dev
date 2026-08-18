<x-admin-layout title="">

    <h1>Settings</h1>

    <br />
    <br />

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('admin.settings.index') }}">
        <div class="row">
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="category" id="category" label="Category" :value="request('category')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="name" id="name" label="Name" :value="request('name')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="value" id="value" label="Value" :value="request('value')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <br />
    <br />

    {{ $settings->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover1 table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'category', 'sort_direction' => $sort_direction]) }}">Category</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'name', 'sort_direction' => $sort_direction]) }}">Name</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'value', 'sort_direction' => $sort_direction]) }}">Value</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_by', 'sort_direction' => $sort_direction]) }}">Created By</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_by', 'sort_direction' => $sort_direction]) }}">Updated By</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($settings as $setting)
                    <tr>
                        <td>{{ $setting->id }}</td>
                        <td>{{ $setting->category }}</td>
                        <td>{{ $setting->name }}</td>
                        <td>{{ $setting->value }}</td>
                        <td>{{ $setting->created_by }}</td>
                        <td>{{ $setting->updated_by }}</td>
                        <td>{{ $setting->created_at }}</td>
                        <td>{{ $setting->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.settings.show', $setting->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $settings->withQueryString()->links() }}

    <br />

    <a href="{{ route('admin.settings.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

    <div hx-get="{{ route('admin.settings.create') }}" hx-swap="outerHTML" class="btn btn-sm btn-secondary">Add (HTMX)</div>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            settings
            @php dump(@$settings) @endphp
        </div>
    @endif

</x-admin-layout>