<x-admin-layout title="">

    <h1>Contractor Login IP</h1>

    <br />
    <br />

    <form method="get"
          accept-charset="utf-8"
          action="{{ route('admin.contractorloginips.index') }}">
        <div class="row">
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="ip_address"
                              label="IP Address"
                              :value="request('ip_address')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="contractor_first"
                              label="Contractor First"
                              :value="request('contractor_first')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="contractor_last"
                              label="Contractor Last"
                              :value="request('contractor_last')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.contractorloginips.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>


    <br />
    <br />

    {{ $contractorloginips->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-hover w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'ip_address', 'sort_direction' => $sort_direction]) }}">IP
                            Address</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'remote_host', 'sort_direction' => $sort_direction]) }}">Remote
                            Host</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'contractor_first', 'sort_direction' => $sort_direction]) }}">Contractor
                            First</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'contractor_last', 'sort_direction' => $sort_direction]) }}">Contractor
                            Last</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'login_count', 'sort_direction' => $sort_direction]) }}">Login
                            Count</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'login_last', 'sort_direction' => $sort_direction]) }}">Login
                            Last</a></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contractorloginips as $contractorloginip)
                    <tr>
                        <td>
                            {{ $contractorloginip->ip_address }}
                            <br />
                            {{ $contractorloginip->ip_range }}
                        </td>
                        <td>
                            {{ $contractorloginip->remote_host }}
                            <br />
                            {{ $contractorloginip->city }}
                            -
                            {{ $contractorloginip->region }}
                            -
                            {{ $contractorloginip->country_code }}
                            &nbsp;
                            <img src="/img/flags/gif/{{ strtolower($contractorloginip->country_code ?? '') }}.gif"
                                 alt="">
                        </td>
                        <td>{{ $contractorloginip->contractor_first }}</td>
                        <td>{{ $contractorloginip->contractor_last }}</td>
                        <td>{{ $contractorloginip->login_count }}</td>
                        <td nowrap>{{ $contractorloginip->created_at }}</td>
                        <td nowrap>{{ $contractorloginip->login_last }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $contractorloginips->withQueryString()->links() }}

    <br />
    <br />

</x-admin-layout>
