<x-admin-layout title="">

    <h1>Contractor Logins</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.contractorlogins.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="contractor"
                               label="Contractor"
                               :options="$contractors"
                               empty="-"
                               :default="request('contractor')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="ip_address"
                              label="IP Address"
                              :value="request('ip_address')" />
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
                <a href="{{ route('admin.contractorlogins.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $contractorlogins->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-hover w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'contractor', 'sort_direction' => $sort_direction]) }}">Contractor</a>
                    </th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'ip_address', 'sort_direction' => $sort_direction]) }}">IP
                            Address</a>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'remote_host', 'sort_direction' => $sort_direction]) }}">Remote
                            Host</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'page_views', 'sort_direction' => $sort_direction]) }}">Page
                            Views</a></th>
                    <th>Uploads</th>
                    <th>Downloads</th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated
                            At</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'logout_at', 'sort_direction' => $sort_direction]) }}">Logout
                            At</a></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contractorlogins as $contractorlogin)
                    <tr>
                        <td>{{ $contractorlogin->contractor }}</td>
                        <td>
                            {{ $contractorlogin->ip_address }}
                            <br />
                            {{ $contractorlogin->remote_host }}
                        </td>
                        <td>{{ $contractorlogin->page_views }}</td>
                        <td>{{ $contractorlogin->uploads }}</td>
                        <td>{{ $contractorlogin->downloads }}</td>
                        <td nowrap>
                            {{ $contractorlogin->created_at }}
                            <br />
                            {{ $contractorlogin->updated_at }}
                            <br />
                            {{ $contractorlogin->time_on_site }}
                        </td>
                        <td>{{ $contractorlogin->logout_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />

    {{ $contractorlogins->withQueryString()->links() }}

    <br />
    <br />

</x-admin-layout>
