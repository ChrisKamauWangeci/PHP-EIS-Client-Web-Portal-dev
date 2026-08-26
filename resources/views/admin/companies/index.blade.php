<x-admin-layout title="">

    <h1>Companies</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.companies.index') }}">

        <div class="row">

            <div class="col-6 col-sm-6 col-md-3 col-lg-2">
                <x-form.input name="C_Name"
                              label="Name"
                              :value="request('C_Name')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-sm-6 col-md-3 col-lg-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.companies.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $companies->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Name', 'sort_direction' => $sort_direction]) }}">Name</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_WebID', 'sort_direction' => $sort_direction]) }}">Web
                            ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_EHR', 'sort_direction' => $sort_direction]) }}">EHR</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_eHealthLink', 'sort_direction' => $sort_direction]) }}">eHealthLink</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'summary', 'sort_direction' => $sort_direction]) }}">Summary</a>
                    </th>
                    @if (@$adminsession['subdomain'] == 'eisdev')
                        <th><a
                               href="{{ Request::fullUrlWithQuery(['sort_field' => 'smartaccess_active', 'sort_direction' => $sort_direction]) }}">Smart
                                Access</a></th>
                        <th><a
                               href="{{ Request::fullUrlWithQuery(['sort_field' => 'caremap360_active', 'sort_direction' => $sort_direction]) }}">CareMap
                                360</a></th>
                    @endif
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr>
                        <td>{{ $company->C_Name }}</td>
                        <td>{{ $company->C_WebID }}</td>
                        <td><img src="/img/icon_{{ $company->C_EHR ?? 0 }}.png"
                                 alt=""></td>
                        <td><img src="/img/icon_{{ $company->C_eHealthLink ?? 0 }}.png"
                                 alt=""></td>
                        <td><img src="/img/icon_{{ $company->summary ?? 0 }}.png"
                                 alt=""></td>
                        @if (@$adminsession['subdomain'] == 'eisdev')
                            <td><img src="/img/icon_{{ $company->smartaccess_active ?? 0 }}.png"
                                     alt=""></td>
                            <td><img src="/img/icon_{{ $company->caremap360_active ?? 0 }}.png"
                                     alt=""></td>
                        @endif
                        <td>
                            <a href="{{ route('admin.companies.show', $company->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                            <a href="{{ route('admin.requestors.index', ['R_Company' => $company->C_Name]) }}"
                               class="btn btn-xs btn-secondary">Requestors</a>
                            <a href="{{ route('admin.workorders.stats', ['R_Company' => $company->C_Name]) }}"
                               class="btn btn-xs btn-secondary">Stats</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $companies->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('admin.companies.create') }}"
       class="btn btn-sm btn-secondary">Create Company</a>

    <br />
    <br />

</x-admin-layout>
