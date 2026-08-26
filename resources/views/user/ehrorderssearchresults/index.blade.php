<x-user-layout title="">

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('#dbfield, #dbconditions').change(function() {
                if ($('#dbvalue').val() == '-') {
                    $('#dbvalue').val('');
                }
                if (($('#dbfield').val() != '') && ($('#dbconditions').val() == '')) {
                    $('#dbconditions').val('eq');
                    $("#dbvalue").prop('required', true);
                }
                if (($('#dbfield').val() == '')) {
                    $('#dbconditions').val('');
                    $('#dbvalue').val('');
                    $("#dbvalue").prop('required', false);
                }
                if ($('#dbconditions').val() == 'empty') {
                    $('#dbvalue').val('-');
                }
                if ($('#dbconditions').val() == 'not_empty') {
                    $('#dbvalue').val('-');
                }
            });

        });
    </script>

    <div class="row">
        <div class="col-auto">
            <h1>EHR Orders Search Results</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrorders.index') }}"
               class="btn btn-sm btn-secondary">View EHR Orders</a>
            <a href="{{ route('user.ehrorderssearchresults.index') }}"
               class="btn btn-sm btn-secondary">View EHR Order Search Results</a>
            <a href="{{ route('user.ehrordersdocuments.index') }}"
               class="btn btn-sm btn-secondary">View EHR Order Documents</a>
        </div>
    </div>

    <br />

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.ehrorderssearchresults.index') }}">

        <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="ehrorder_id"
                              id="ehrorder_id"
                              label="EHR Order ID"
                              :value="request('ehrorder_id')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="workorder_id"
                              label="Workorder ID"
                              :value="request('workorder_id')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="managing_organization"
                              label="Managing Organization"
                              :value="request('managing_organization')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.select name="service_provider"
                               label="Service Provider"
                               id="service_provider"
                               :options="Helper::ehrproviders()"
                               empty="-"
                               :default="request('service_provider')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="company_name"
                              id="company_name"
                              label="Company Name"
                              :value="request('company_name')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="first_name"
                              id="first_name"
                              label="First Name"
                              :value="request('first_name')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="last_name"
                              id="last_name"
                              label="Last Name"
                              :value="request('last_name')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="status"
                              label="Status"
                              :value="request('status')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.select name="consent_required"
                               label="Consent Required"
                               :default="request('consent_required')"
                               :options="['all' => 'Any', 'null' => 'Not Required', 'not_null' => 'Required']" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                @php
                    $dbfieldselects = [
                        'ehrorderssearchresults.status' => 'Status',
                        'ehrorderssearchresults.service_provider' => 'Service Provider',
                        'ehrorderssearchresults.managing_organization' => 'Managing Organization',
                        'ehrorderssearchresults.operation_outcome' => 'Operation Outcome',
                        'ehrorderssearchresults.received_at' => 'Received At',
                    ];
                @endphp
                <x-form.select name="dbfield"
                               label="Field"
                               id="dbfield"
                               :options="$dbfieldselects"
                               empty="-"
                               :default="request('dbfield')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                @php
                    $dbconditionsselects = [
                        'eq' => 'Is equal to',
                        'neq' => 'Is not equal to',
                        'contains' => 'Contains',
                        'not_contains' => 'Does not contain',
                        'starts_with' => 'Begins with',
                        'ends_with' => 'Ends with',
                        'empty' => 'Is empty',
                        'not_empty' => 'Is not empty',
                    ];
                @endphp
                <x-form.select name="dbconditions"
                               label="Condition"
                               id="dbconditions"
                               :options="$dbconditionsselects"
                               empty="-"
                               :default="request('dbconditions')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="dbvalue"
                              label="Value"
                              id="dbvalue"
                              :value="request('dbvalue')"
                              autocomplete="off"
                              maxlength="50" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date"
                              name="received_at_from"
                              label="Received At (From)"
                              :value="request('received_at_from')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date"
                              name="received_at_to"
                              label="Received At (To)"
                              :value="request('received_at_to')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date"
                              name="created_at_from"
                              label="Created At (From)"
                              :value="request('created_at_from')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date"
                              name="created_at_to"
                              label="Created At (To)"
                              :value="request('created_at_to')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.ehrorderssearchresults.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />

    <a href="{{ route('user.ehrorderssearchresults.export', array_merge(request()->query(), ['type' => 'csv'])) }}">Export
        CSV</a>
    &nbsp;
    <a href="{{ route('user.ehrorderssearchresults.export', array_merge(request()->query(), ['type' => 'xlsx'])) }}">Export
        Excel</a>

    <br />

    {{ $ehrorderssearchresults->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'ehrorder_id', 'sort_direction' => $sort_direction]) }}">EHR
                            Order ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">WO
                            ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'managing_organization', 'sort_direction' => $sort_direction]) }}">Managing
                            Organization</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'service_provider', 'sort_direction' => $sort_direction]) }}">SP</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'company_name', 'sort_direction' => $sort_direction]) }}">Company
                            Name</a></th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'first_name', 'sort_direction' => $sort_direction]) }}">First
                            Name</a>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'last_name', 'sort_direction' => $sort_direction]) }}">Last
                            Name</a>
                    </th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'consent_required', 'sort_direction' => $sort_direction]) }}"
                           title="Consent Required">CR</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => $sort_direction]) }}">Status</a>
                    </th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'operation_outcome', 'sort_direction' => $sort_direction]) }}">Operation
                            Outcome</a>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'operation_outcome_at', 'sort_direction' => $sort_direction]) }}">Operation
                            Outcome At</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'is_active', 'sort_direction' => $sort_direction]) }}">Is
                            Active</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'requested_at', 'sort_direction' => $sort_direction]) }}">Requested
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'submitted_at', 'sort_direction' => $sort_direction]) }}">Submitted
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'received_at', 'sort_direction' => $sort_direction]) }}">Received
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated
                            At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ehrorderssearchresults as $ehrorderssearchresult)
                    <tr>
                        <td>{{ $ehrorderssearchresult->id }}</td>
                        <td><a
                               href="{{ route('user.ehrorders.show', $ehrorderssearchresult->ehrorder_id) }}">{{ $ehrorderssearchresult->ehrorder_id }}</a>
                        </td>
                        <td>{{ $ehrorderssearchresult->workorder_id }}</td>
                        <td>
                            {{ $ehrorderssearchresult->managing_organization }}
                            <br />
                            {{ $ehrorderssearchresult->organization_reference }}
                        </td>
                        <td>{{ $ehrorderssearchresult->service_provider }}</td>
                        <td>{{ $ehrorderssearchresult->company_name }}</td>
                        <td>{{ $ehrorderssearchresult->first_name }} {{ $ehrorderssearchresult->last_name }}</td>
                        <td>{{ $ehrorderssearchresult->consent_required ? 'yes' : '' }}</td>
                        <td>{{ $ehrorderssearchresult->status }}</td>
                        <td class="{{ !empty($ehrorderssearchresult->operation_outcome) ? 'bg-danger-subtle' : '' }}">
                            {{ $ehrorderssearchresult->operation_outcome }}
                            {{ $ehrorderssearchresult->operation_outcome_at?->format('m/d/Y H:i:s') }}
                        </td>
                        <td><img src="/img/icon_{{ $ehrorderssearchresult->is_active }}.png"
                                 alt=""></td>
                        <td>{{ $ehrorderssearchresult->requested_at }}</td>
                        <td>{{ $ehrorderssearchresult->submitted_at }}</td>
                        <td class="{{ $ehrorderssearchresult->received_at ? 'bg-success-subtle' : '' }}">
                            {{ $ehrorderssearchresult->received_at }}</td>
                        <td>{{ $ehrorderssearchresult->created_at }}</td>
                        <td>{{ $ehrorderssearchresult->updated_at }}</td>
                        <td>
                            <a href="{{ route('user.ehrorderssearchresults.show', $ehrorderssearchresult->id) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $ehrorderssearchresults->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('user.ehrorderssearchresultsexclusions.index') }}"
       class="btn btn-sm btn-secondary">View EHR Order Search Results Exclusions</a>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ehrorderssearchresults
            @php dump(@$ehrorderssearchresults) @endphp
        </div>
    @endif

</x-user-layout>
