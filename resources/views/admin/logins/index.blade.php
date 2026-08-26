<x-admin-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Requestor Logins</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.logins.stats') }}"
               class="btn btn-sm btn-secondary">IP Address Most Used</a>
        </div>
    </div>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.logins.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="company"
                              label="Company"
                              :value="request('company')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="requestor"
                              label="Requestor"
                              :value="request('requestor')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="username"
                              label="Username"
                              :value="request('username')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="ip_address"
                              label="IP Address"
                              :value="request('ip_address')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date"
                              name="from"
                              label="From"
                              :value="request('from')"
                              min="{{ now()->subYear(5)->format('Y-m-d') }}"
                              max="{{ now()->addDays(1)->format('Y-m-d') }}" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date"
                              name="to"
                              label="To"
                              :value="request('to')"
                              min="{{ now()->subYear(5)->format('Y-m-d') }}"
                              max="{{ now()->addDays(1)->format('Y-m-d') }}" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.logins.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $logins->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-hover w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}">Company</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'requestor', 'sort_direction' => $sort_direction]) }}">Requestor</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'username', 'sort_direction' => $sort_direction]) }}">Username</a>
                    </th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'ip_address', 'sort_direction' => $sort_direction]) }}">IP
                            Address</a>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'remote_host', 'sort_direction' => $sort_direction]) }}">IP
                            Remote Host</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created', 'sort_direction' => $sort_direction]) }}">Created</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logins as $login)
                    <tr>
                        <td>{{ $login->company }}</td>
                        <td>{{ $login->requestor }}</td>
                        <td>{{ $login->username }}</td>
                        <td>
                            {{ $login->ip_address }}
                            <br />
                            {{ $login->remote_host }}
                        </td>
                        <td nowrap>{{ $login->created }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />

    {{ $logins->withQueryString()->links() }}

    <br />
    <br />

</x-admin-layout>
