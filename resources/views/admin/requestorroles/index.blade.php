<x-admin-layout title="">

    <h1>Requestor Roles</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.requestorroles.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="company"
                              label="Company"
                              :value="request('company')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="name"
                              label="Name"
                              :value="request('name')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.requestorroles.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $requestorroles->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}">Company</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'name', 'sort_direction' => $sort_direction]) }}">Name</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'role', 'sort_direction' => $sort_direction]) }}">Role</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'active_in_order', 'sort_direction' => $sort_direction]) }}">Active
                            in Order</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'active_in_search', 'sort_direction' => $sort_direction]) }}">Active
                            in Search</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestorroles as $requestorrole)
                    <tr>
                        <td>{{ $requestorrole->id }}</td>
                        <td>{{ $requestorrole->company }}</td>
                        <td>{{ $requestorrole->name }}</td>
                        <td>{{ $requestorrole->role }}</td>
                        <td><img src="/img/icon_{{ $requestorrole->active_in_order }}.png"
                                 alt=""></td>
                        <td><img src="/img/icon_{{ $requestorrole->active_in_search }}.png"
                                 alt=""></td>
                        <td>{{ $requestorrole->created_at }}</td>
                        <td>{{ $requestorrole->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.requestorroles.show', $requestorrole->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                            <a href="{{ route('admin.requestorroles.edit', $requestorrole->id) }}"
                               class="btn btn-xs btn-secondary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $requestorroles->withQueryString()->links() }}

    <br />

    <br />
    <br />

    @if ($adminsession['contractor']['accesslevel'])
        <a href="{{ route('admin.requestorroles.create') }}"
           class="btn btn-sm btn-secondary">Add</a>
    @endif

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            requestorroles
            @php dump(@$requestorroles) @endphp
        </div>
    @endif

</x-admin-layout>
