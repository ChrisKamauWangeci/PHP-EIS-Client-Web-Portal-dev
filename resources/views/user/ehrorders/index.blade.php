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
            <h1>EHR Orders</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrorders.index') }}" class="btn btn-sm btn-secondary">View EHR Orders</a>
            <a href="{{ route('user.ehrorderssearchresults.index') }}" class="btn btn-sm btn-secondary">View EHR Order Search Results</a>
            <a href="{{ route('user.ehrordersdocuments.index') }}" class="btn btn-sm btn-secondary">View EHR Order Documents</a>
        </div>
    </div>

    <br />
    <br />

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.ehrorders.index') }}">
        <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="id" id="id" label="ID" :value="request('id')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="workorder_id" id="workorder_id" label="Workorder ID" :value="request('workorder_id')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.select name="service_provider" label="Service Provider" id="service_provider" :options="Helper::ehrproviders()" empty="-" :default="request('service_provider')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="company_name" id="company_name" label="Company Name" :value="request('company_name')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="first_name" id="first_name" label="First Name" :value="request('first_name')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="last_name" id="last_name" label="Last Name" :value="request('last_name')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="gender" id="gender" label="Gender" :value="request('gender')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="status" id="status" label="Status" :value="request('status')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                @php
                    $dbfieldselects = [
                        'status' => 'Status',
                        'state' => 'State',
                        'submission_type' => 'Submission Type',
                        'submitted_at' => 'Submitted At',
                    ];
                @endphp
                <x-form.select name="dbfield" label="Field" id="dbfield" :options="$dbfieldselects" empty="-" :default="request('dbfield')" />
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
                <x-form.select name="dbconditions" label="Condition" id="dbconditions" :options="$dbconditionsselects" empty="-" :default="request('dbconditions')" />
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input name="dbvalue" label="Value" id="dbvalue" :value="request('dbvalue')" autocomplete="off" maxlength="50" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date" name="submitted_at_from" id="submitted_at_from" label="Submitted At (From)" :value="request('submitted_at_from')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date" name="submitted_at_to" id="submitted_at_to" label="Submitted At (To)" :value="request('submitted_at_to')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date" name="created_at_from" id="created_at_from" label="Created At (From)" :value="request('created_at_from')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <x-form.input type="date" name="created_at_to" id="created_at_to" label="Created At (To)" :value="request('created_at_to')" />
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.ehrorders.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <br />
    <br />

    {{ $ehrorders->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover1 table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'service_provider', 'sort_direction' => $sort_direction]) }}" title="Service Provider">SP</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'company_name', 'sort_direction' => $sort_direction]) }}" title="Company">Company</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'first_name', 'sort_direction' => $sort_direction]) }}">First Name</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'last_name', 'sort_direction' => $sort_direction]) }}">Last Name</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'gender', 'sort_direction' => $sort_direction]) }}">G</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'birth_date', 'sort_direction' => $sort_direction]) }}">Birth Date</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'state', 'sort_direction' => $sort_direction]) }}">State</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'submission_type', 'sort_direction' => $sort_direction]) }}">Submission Type</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => $sort_direction]) }}">Status</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'submitted_at', 'sort_direction' => $sort_direction]) }}">Submitted At</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created At</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'updated_at', 'sort_direction' => $sort_direction]) }}">Updated At</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ehrorders as $ehrorder)
                    <tr>
                        <td>{{ $ehrorder->id }}</td>
                        <td>{{ $ehrorder->workorder_id }}</td>
                        <td>{{ $ehrorder->service_provider }}</td>
                        <td>{{ $ehrorder->company_name }}</td>
                        <td>{{ $ehrorder->first_name }}</td>
                        <td>{{ $ehrorder->last_name }}</td>
                        <td>{{ $ehrorder->gender }}</td>
                        <td>{{ $ehrorder->birth_date }}</td>
                        <td>{{ $ehrorder->state }}</td>
                        <td>{{ $ehrorder->submission_type }}</td>
                        <td>{{ $ehrorder->status }}</td>
                        <td>{{ $ehrorder->submitted_at }}</td>
                        <td>{{ $ehrorder->created_at }}</td>
                        <td>{{ $ehrorder->updated_at }}</td>
                        <td>
                            <a href="{{ route('user.ehrorders.show', $ehrorder->id) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                    @if ($ehrorder->ehrorderssearchresults->isNotEmpty())
                        <tr>
                            <td colspan="15" class="bg-body">
                                <table class="table table-sm table-bordered w-auto m-0">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td>Healthcare Organization</td>
                                            <td>Consent</td>
                                            <td>Status</td>
                                            <td>Created By</td>
                                            <td>Requested At</td>
                                            <td>Submitted At</td>
                                            <td>Received At</td>
                                            <td>Operation Outcome</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ehrorder->ehrorderssearchresults as $ehrorderssearchresult)
                                            @if ($ehrorderssearchresult->managing_organization)
                                                @include('user.ehrorderssearchresults._status_button', ['ehrorderssearchresult' => $ehrorderssearchresult])
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $ehrorders->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('user.ehrorders.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ehrorders
            @php dump(@$ehrorders) @endphp
        </div>
    @endif

</x-user-layout>
