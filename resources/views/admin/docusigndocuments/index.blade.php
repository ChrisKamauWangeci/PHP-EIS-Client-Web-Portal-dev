<x-admin-layout title="">

    <h1>Docusign Documents</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.docusigndocuments.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                @php
                    $signingtypesselects = [
                        'embedded' => 'embedded',
                        'email' => 'email',
                    ];
                @endphp
                <x-form.select name="signingtype"
                               label="Signing Type"
                               :options="$signingtypesselects"
                               empty="-"
                               :default="request('signingtype')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="db"
                              label="DB"
                              :value="request('db')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="text"
                              name="envelopeid"
                              label="Envelope ID"
                              :value="request('envelopeid')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="number"
                              name="workorder_id"
                              label="Workorder ID"
                              :value="request('workorder_id')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="facility"
                              label="Facility"
                              :value="request('facility')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="client"
                              label="Client"
                              :value="request('client')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="company"
                              label="Company"
                              :value="request('company')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="requestor"
                              label="Requestor"
                              :value="request('requestor')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="first_name"
                              label="First Name"
                              :value="request('first_name')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="last_name"
                              label="Last Name"
                              :value="request('last_name')"
                              autocomplete="off" />
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
                <a href="{{ route('admin.docusigndocuments.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $docusigndocuments->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'db', 'sort_direction' => $sort_direction]) }}">DB</a>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'signingtype', 'sort_direction' => $sort_direction]) }}">Signing
                            Type</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Work
                            Order ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'facility', 'sort_direction' => $sort_direction]) }}">Facility</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'client', 'sort_direction' => $sort_direction]) }}">Client</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'company', 'sort_direction' => $sort_direction]) }}">Company</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'requestor', 'sort_direction' => $sort_direction]) }}">Requestor</a>
                    </th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'first_name', 'sort_direction' => $sort_direction]) }}">First
                            Name</a>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'last_name', 'sort_direction' => $sort_direction]) }}">Last
                            Name</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => $sort_direction]) }}">Status</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($docusigndocuments as $docusigndocument)
                    <tr>
                        <td>{{ $docusigndocument->id }}</td>
                        <td>
                            {{ $docusigndocument->db }}
                            <br />
                            {{ $docusigndocument->signingtype }}
                        </td>
                        <td>{{ $docusigndocument->workorder_id }}</td>
                        <td>
                            {{ $docusigndocument->facility }}
                            <br />
                            <small>{{ $docusigndocument->slug }}</small>
                        </td>
                        <td>{{ $docusigndocument->client }}</td>
                        <td>{{ $docusigndocument->company }}</td>
                        <td>{{ $docusigndocument->requestor }}</td>
                        <td>
                            {{ $docusigndocument->first_name }}
                            {{ $docusigndocument->last_name }}
                        </td>
                        <td>{{ $docusigndocument->status }}</td>
                        <td>{{ $docusigndocument->created_at }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.docusigndocuments.show', $docusigndocument->id) }}"
                               class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $docusigndocuments->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('admin.docusigndocuments.stats') }}"
       class="btn btn-sm btn-secondary">Stats</a>

    <br />
    <br />

</x-admin-layout>
