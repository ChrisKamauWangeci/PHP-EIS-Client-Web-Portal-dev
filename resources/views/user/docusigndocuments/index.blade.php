<x-user-layout title="">

    <h1>Docusign Documents</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.docusigndocuments.index') }}">

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                @php
                    $environmenttypesselects = [
                        'production' => 'production',
                        'test' => 'test',
                    ];
                @endphp
                <x-form.select name="environment"
                               label="Environment"
                               :options="$environmenttypesselects"
                               empty="-"
                               :default="request('environment')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
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

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                @php
                    $dbselects = [
                        'eis' => 'eis',
                        'nyl' => 'nyl',
                        'usaa' => 'usaa',
                        'eisuat' => 'eisuat',
                    ];
                @endphp
                <x-form.select name="db"
                               label="DB"
                               :options="$dbselects"
                               empty="-"
                               :default="request('db')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input type="number"
                              name="workorder_id"
                              label="Workorder ID"
                              :value="request('workorder_id')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input type="text"
                              name="envelopeid"
                              label="Envelope ID"
                              :value="request('envelopeid')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="facility"
                              label="Facility"
                              :value="request('facility')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="slug"
                              label="Slug"
                              :value="request('slug')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="client"
                              label="Client"
                              :value="request('client')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="requestor"
                              label="Requestor"
                              :value="request('requestor')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="first_name"
                              label="First Name"
                              :value="request('first_name')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="last_name"
                              label="Last Name"
                              :value="request('last_name')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="email"
                              label="Email"
                              :value="request('email')"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                @php
                    $statusselects = [
                        'envelope-sent' => 'envelope-sent',
                        'envelope-resent' => 'envelope-resent',
                        'envelope-delivered' => 'envelope-delivered',
                        'envelope-completed' => 'envelope-completed',
                        'envelope-voided' => 'envelope-voided',
                        'envelope-deleted' => 'envelope-deleted',
                        'envelope-purge' => 'envelope-purge',
                        'recipient-resent' => 'recipient-resent',
                        'recipient-authenticationfailed' => 'recipient-authenticationfailed',
                    ];
                @endphp
                <x-form.select name="status"
                               label="Docusign Status"
                               :options="$statusselects"
                               empty="-"
                               :default="request('status')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                @php
                    $options = [
                        'Incomplete' => 'Incomplete',
                        'Complete' => 'Complete',
                        'Cancel' => 'Cancel',
                        'Delete' => 'Delete',
                        'Duplicate' => 'Duplicate',
                    ];
                @endphp
                <x-form.select name="W_Status"
                               label="Workorder Status"
                               :options="$options"
                               empty="-"
                               :default="request('W_Status')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="created_at_from"
                              label="Created From"
                              :value="request('created_at_from')"
                              type="date"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="created_at_to"
                              label="Created To"
                              :value="request('created_at_to')"
                              type="date"
                              autocomplete="off" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.docusigndocuments.index') }}"
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
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'environment', 'sort_direction' => $sort_direction]) }}">Environment</a>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'db', 'sort_direction' => $sort_direction]) }}">DB</a>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'signingtype', 'sort_direction' => $sort_direction]) }}">Signing
                            Type</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder
                            ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'facility', 'sort_direction' => $sort_direction]) }}">Facility</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'client', 'sort_direction' => $sort_direction]) }}">Client</a>
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
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'email', 'sort_direction' => $sort_direction]) }}">Email</a>
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
                            {{ $docusigndocument->environment }}
                            <br />
                            {{ $docusigndocument->db }}
                            <br />
                            {{ $docusigndocument->signingtype }}
                        </td>
                        <td>
                            <a
                               href="{{ route('user.workorders.show', $docusigndocument->workorder_id) }}">{{ $docusigndocument->workorder_id }}</a>
                            <br />
                            <small>{{ $docusigndocument->workorder->W_Status ?? '' }}</small>
                            <br />
                            <small>{{ $docusigndocument->workorder->W_CompletedDate ? $docusigndocument->workorder->W_CompletedDate->format('m/d/Y') : '' }}</small>
                        </td>
                        <td>
                            {{ $docusigndocument->facility }}
                            <br />
                            <small>{{ $docusigndocument->slug }}</small>
                        </td>
                        <td>{{ $docusigndocument->client }}</td>
                        <td>{{ $docusigndocument->requestor }}</td>
                        <td>
                            {{ $docusigndocument->first_name }}
                            {{ $docusigndocument->last_name }}
                            <br />
                            {{ $docusigndocument->email }}
                        </td>
                        <td class="{!! Helper::docusignstatus($docusigndocument->status) !!}">
                            {{ $docusigndocument->status }}
                        </td>
                        <td nowrap>{{ $docusigndocument->created_at }}</td>
                        <td class="actions">
                            <a href="{{ route('user.docusigndocuments.show', $docusigndocument->id) }}"
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

    <a href="{{ route('user.docusigndocuments.stats') }}"
       class="btn btn-sm btn-secondary">Stats</a>

    <br />
    <br />

</x-user-layout>
