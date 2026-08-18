<x-admin-layout title="">

    <h1>Requestor Login IP</h1>

    <br />
    <br />

    <form method="get" accept-charset="utf-8" action="{{ route('admin.loginips.index') }}">
        <div class="row">
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="ip_address" label="IP Address" :value="request('ip_address')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="company" label="Company" :value="request('company')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="username" label="Username" :value="request('username')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.loginips.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <br />
    <br />

    {{ $loginips->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-hover w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'ip_address', 'sort_direction' => $sort_direction]) }}">IP Address</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}">Company</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'username', 'sort_direction' => $sort_direction]) }}">Username</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'login_count', 'sort_direction' => $sort_direction]) }}">Login Count</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created', 'sort_direction' => $sort_direction]) }}">Created</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'login_last', 'sort_direction' => $sort_direction]) }}">Login Last</a></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loginips as $loginip)
                    <tr>
                        <td>
                            {{ $loginip->ip_address }}
                            <br />
                            {{ $loginip->ip_range }}
                        </td>
                        <td>{{ $loginip->company }}</td>
                        <td>{{ $loginip->username }}</td>
                        <td>{{ $loginip->login_count }}</td>
                        <td nowrap>{{ $loginip->created }}</td>
                        <td nowrap>{{ $loginip->login_last }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $loginips->withQueryString()->links() }}

    <br />
    <br />

</x-admin-layout>