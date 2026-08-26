<x-admin-layout title="">

    <h1>Requestor Password Changes</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.requestor-password-changes.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="action"
                               label="Action"
                               :options="['change' => 'change', 'reset' => 'reset']"
                               empty="-"
                               :default="request('action')" />
            </div>

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
                <x-form.input name="email"
                              label="Email"
                              :value="request('email')"
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
                              name="created_at_from"
                              label="Created From"
                              :value="request('created_at_from')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date"
                              name="created_at_to"
                              label="Created To"
                              :value="request('created_at_to')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.requestor-password-changes.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $requestorPasswordChanges->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'action', 'sort_direction' => $sort_direction]) }}">Action</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}">Company</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'requestor', 'sort_direction' => $sort_direction]) }}">Requestor</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'username', 'sort_direction' => $sort_direction]) }}">Username</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'email', 'sort_direction' => $sort_direction]) }}">Email</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'ip_address', 'sort_direction' => $sort_direction]) }}">IP
                            Address</a></th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'country_iso', 'sort_direction' => $sort_direction]) }}">Country</a>
                        <br />
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'region', 'sort_direction' => $sort_direction]) }}">Region</a>
                        <br />
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'city', 'sort_direction' => $sort_direction]) }}">City</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestorPasswordChanges as $requestorPasswordChange)
                    <tr>
                        <td>{{ $requestorPasswordChange->action }}</td>
                        <td>{{ $requestorPasswordChange->company }}</td>
                        <td>{{ $requestorPasswordChange->requestor }}</td>
                        <td>{{ $requestorPasswordChange->username }}</td>
                        <td>{{ $requestorPasswordChange->email }}</td>
                        <td>{{ $requestorPasswordChange->ip_address }}</td>
                        <td nowrap>
                            <img src="/img/flags/gif/{{ strtolower($requestorPasswordChange->country_iso ?? '') }}.gif"
                                 alt="">
                            {{ $requestorPasswordChange->country_iso }} {{ $requestorPasswordChange->region_iso }}
                            {{ $requestorPasswordChange->city }}
                        </td>
                        <td nowrap>{{ $requestorPasswordChange->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.requestor-password-changes.show', $requestorPasswordChange->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $requestorPasswordChanges->withQueryString()->links() }}

    <br />
    <br />

    <br />
    <br />

</x-admin-layout>
