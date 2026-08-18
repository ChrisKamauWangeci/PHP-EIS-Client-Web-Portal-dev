<x-admin-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Requestor Login Attempts</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.loginattempts.stats') }}" class="btn btn-sm btn-secondary">IP Address Most Used</a>
        </div>
    </div>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('admin.loginattempts.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="username" label="Username" :value="request('username')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="ip_address" label="IP Address" :value="request('ip_address')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.loginattempts.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $loginattempts->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-hover w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'username', 'sort_direction' => $sort_direction]) }}">Username</a>
                    </th>
                    <th>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'ip_address', 'sort_direction' => $sort_direction]) }}">IP Address</a>
                        <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'remote_host', 'sort_direction' => $sort_direction]) }}">Remote Host</a>
                    </th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loginattempts as $loginattempt)
                    <tr>
                        <td>{{ $loginattempt->username }}</td>
                        <td>
                            {{ $loginattempt->ip_address }}
                            <br />
                            {{ $loginattempt->remote_host }}
                        </td>
                        <td nowrap>{{ $loginattempt->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />

    {{ $loginattempts->withQueryString()->links() }}

    <br />
    <br />

</x-admin-layout>