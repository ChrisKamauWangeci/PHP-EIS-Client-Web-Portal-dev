<x-admin-layout title="">

    <h1>Contractor Login Attempts</h1>

    <br />
    <br />

    <form method="get"
          accept-charset="utf-8"
          action="{{ route('admin.contractorloginattempts.index') }}">
        <div class="row">
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="username"
                              label="Username"
                              :value="request('username')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="ip_address"
                              label="IP Address"
                              :value="request('ip_address')" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.contractorloginattempts.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <br />
    <br />

    {{ $contractorloginattempts->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-hover w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'username', 'sort_direction' => $sort_direction]) }}">username</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'ip_address', 'sort_direction' => $sort_direction]) }}">ip_address</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'remote_host', 'sort_direction' => $sort_direction]) }}">remote_host</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">created_at</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contractorloginattempts as $contractorloginattempt)
                    <tr>
                        <td>{{ $contractorloginattempt->username }}</td>
                        <td>{{ $contractorloginattempt->ip_address }}</td>
                        <td>
                            {{ $contractorloginattempt->remote_host }}
                            <br />
                            <img src="/img/flags/gif/{{ strtolower($contractorloginattempt->country_code ?? '') }}.gif"
                                 alt="">
                            &nbsp;
                            {{ $contractorloginattempt->city }}
                            -
                            {{ $contractorloginattempt->region }}
                            -
                            {{ $contractorloginattempt->country_code }}
                        </td>
                        <td nowrap>{{ $contractorloginattempt->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $contractorloginattempts->withQueryString()->links() }}

    <br />
    <br />

</x-admin-layout>
