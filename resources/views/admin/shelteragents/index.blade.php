<x-admin-layout title="Shelter Agents">

    <h1>Shelter Agents</h1>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('admin.shelteragents.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="name" label="Name" :value="request('name')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="email" label="Email" :value="request('email')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="role" label="Role" :options="['' => 'All', 'sdl' => 'SDL', 'agent' => 'Agent']" :default="request('role')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="sdl_district_number" label="SDL District" :value="request('sdl_district_number')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="agent_code" label="Agent Code" :value="request('agent_code')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.shelteragents.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $shelteragents->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'name', 'sort_direction' => $sort_direction]) }}">Name</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'email', 'sort_direction' => $sort_direction]) }}">Email</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'role', 'sort_direction' => $sort_direction]) }}">Role</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'sdl_district_number', 'sort_direction' => $sort_direction]) }}">SDL District</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'agent_code', 'sort_direction' => $sort_direction]) }}">Agent Code</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'is_active', 'sort_direction' => $sort_direction]) }}">Active</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shelteragents as $shelteragent)
                    <tr>
                        <td>{{ $shelteragent->id }} </td>
                        <td>{{ $shelteragent->name }} </td>
                        <td>{{ $shelteragent->email }} </td>
                        <td>{{ $shelteragent->role }} </td>
                        <td>{{ $shelteragent->sdl_district_number }} </td>
                        <td>{{ $shelteragent->agent_code }}</td>
                        <td><img src="/img/icon_{{ $shelteragent->is_active }}.png" alt=""></td>
                        <td>
                            <a href="{{ route('admin.shelteragents.show', $shelteragent->id ) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $shelteragents->withQueryString()->links() }}

    <br />
    <br />

</x-admin-layout>