<x-admin-layout title="">

    <div class="row">
        <div class="col-6">
            <h1>Requestors</h1>
        </div>
        <div class="col-6 text-end">
            @if ($adminsession['contractor']['accesslevel'])
                <a href="{{ route('admin.requestors.create') }}" class="btn btn-sm btn-secondary">Add</a>
            @endif
        </div>
    </div>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('admin.requestors.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="R_Company" label="Company" :value="request('R_Company')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="R_Name" label="Name" :value="request('R_Name')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="R_LoginEmail" label="Login" :value="request('R_LoginEmail')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="R_Email" label="Email" :value="request('R_Email')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="R_SuperUser" label="Super User" :options="['' => 'All', '1' => 'Yes', '0' => 'No']" :default="request('R_SuperUser')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="R_Active" label="Active" :options="['' => 'All', '1' => 'Yes', '0' => 'No']" :default="request('R_Active')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.requestors.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $requestors->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_ID', 'sort_direction' => $sort_direction]) }}">ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_Company', 'sort_direction' => $sort_direction]) }}">Company</a></th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_Name', 'sort_direction' => $sort_direction]) }}">Name</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_LoginEmail', 'sort_direction' => $sort_direction]) }}">Login</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_Email', 'sort_direction' => $sort_direction]) }}">Email</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_SSOID', 'sort_direction' => $sort_direction]) }}">SSO ID</a>
                    </th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'requestorrole_id', 'sort_direction' => $sort_direction]) }}">Requestor Role ID</a>
                        <br />
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'websiteconfig_id', 'sort_direction' => $sort_direction]) }}">Website Config ID</a>
                    </th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_SuperUser', 'sort_direction' => $sort_direction]) }}">Super<br />User</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_NoOrder', 'sort_direction' => $sort_direction]) }}">No Order</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_ViewRecords', 'sort_direction' => $sort_direction]) }}">View<br />Records</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_Active', 'sort_direction' => $sort_direction]) }}">Active</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'login_last', 'sort_direction' => $sort_direction]) }}">Login Last</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_PWDate', 'sort_direction' => $sort_direction]) }}">Password Last Changed</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestors as $requestor)
                    <tr>
                        <td>{{ $requestor->R_ID }} </td>
                        <td>{{ $requestor->R_Company }}</td>
                        <td>
                            {{ $requestor->R_Name }}
                            <br />
                            {{ $requestor->R_LoginEmail }}
                            <br />
                            {{ $requestor->R_Email }}
                            <br />
                            {{ $requestor->R_SSOID }}
                        </td>
                        <td>
                            {{ $requestor->requestorrole_id }} {{ $requestor->requestorrole?->name }}
                            <br />
                            {{ $requestor->websiteconfig_id }} {{ $requestor->websiteconfig?->name }}
                        </td>
                        <td><img src="/img/icon_{{ $requestor->R_SuperUser }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $requestor->R_NoOrder }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $requestor->R_ViewRecords }}.png" alt=""></td>
                        <td><img src="/img/icon_{{ $requestor->R_Active }}.png" alt=""></td>
                        <td nowrap>{{ $requestor->login_last }}</td>
                        <td nowrap>{{ $requestor->R_PWDate?->format('Y-m-d') }}</td>
                        <td nowrap>
                            <a href="{{ route('admin.requestors.show', $requestor) }}" class="btn btn-xs btn-secondary">View</a>
                            <a href="{{ route('admin.requestors.edit', $requestor) }}" class="btn btn-xs btn-secondary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $requestors->withQueryString()->links() }}

    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            requestors
            @php dump(@$requestors) @endphp
        </div>
    @endif

    <br />

</x-admin-layout>
