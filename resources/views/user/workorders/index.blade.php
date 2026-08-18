<x-user-layout title="">

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

            $('form').submit(function() {
                $('button[type="submit"]').attr('disabled', 'disabled');
            });

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

            const applicant_social_security = document.getElementById('W_SS');

            applicant_social_security.addEventListener('input', e =>
                e.target.value = e.target.value.replace(/\D/g, '').slice(0, 9)
            );

            applicant_social_security.addEventListener('paste', e => {
                e.preventDefault();
                e.target.value = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 9);
            });

            var elapseddays = document.getElementsByClassName('elapseddays');

            var elapsed = function() {
                var from = new Date(new Date().setDate(new Date().getDate() - this.getAttribute("data-elapsed")));
                var from = from.toISOString().split('T')[0];
                var to = new Date();
                var to = to.toISOString().split('T')[0];
                document.getElementById('receivedfrom').value = from;
                document.getElementById('receivedto').value = to;
            };

            for (var i = 0; i < elapseddays.length; i++) {
                elapseddays[i].addEventListener('click', elapsed, false);
            }

        });

        function toggle(source) {
            var checkboxes = document.querySelectorAll('.checkboxes');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source) {
                    checkboxes[i].checked = source.checked;
                }
            }
        }
    </script>

    <h1>{{ ucwords($type) }} Workorders</h1>

    Received date:
    <span class="elapseddays text-decoration-underline" data-elapsed="30">last 30 days</span>
    &nbsp;
    <span class="elapseddays text-decoration-underline" data-elapsed="60">last 60 days</span>
    &nbsp;
    <span class="elapseddays text-decoration-underline" data-elapsed="90">last 90 days</span>
    &nbsp;
    <span class="elapseddays text-decoration-underline" data-elapsed="120">last 120 days</span>
    &nbsp;
    <span class="elapseddays text-decoration-underline" data-elapsed="150">last 150 days</span>

    <form method="post" accept-charset="utf-8" id="searchform" action="{{ route('user.workorders.prg') }}">
        @csrf

        <input type="hidden" name="search" value="1">
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="row">

            @if ($database)
                <div class="col-4 col-md-4 col-lg-2 pt-2">
                    @php
                        $options = [
                            'eis' => 'eis',
                            'nyl' => 'nyl',
                            'usaa' => 'usaa',
                            'ehr' => 'ehr',
                        ];
                        if ($subdomain == 'eisuat') {
                            $options['eisuat'] = 'eisuat';
                        }
                    @endphp
                    <x-form.select name="database" label="Database" :options="$options" empty="-" :default="request('database')" />
                </div>
            @endif

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="W_Workorder" label="Workorder ID" :value="request('W_Workorder')" type="text" pattern="\d*" autocomplete="off" maxlength="8" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.select name="W_Owner" label="Assigned To" :options="$contractorsselectswithempty" empty="-" :default="request('W_Owner')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                @php
                    $statusesselects = [
                        'Incomplete' => 'Incomplete',
                        'Complete' => 'Complete',
                        'Cancel' => 'Cancel',
                        'Duplicate' => 'Duplicate',
                        'Delete' => 'Delete',
                    ];
                @endphp
                <x-form.select name="W_Status" label="Status" :options="$statusesselects" empty="-" :default="request('W_Status')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="W_FirstName" label="First Name" :value="request('W_FirstName')" maxlength="50" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="W_LastName" label="Last Name" :value="request('W_LastName')" maxlength="50" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="W_SS" label="Social Security" id="W_SS" :value="request('W_SS')" type="text" pattern="\d*" autocomplete="off" maxlength="9" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="W_DOB" label="Date of Birth" :value="request('W_DOB')" type="date" autocomplete="off" min="1900-01-01" max="2030-01-01" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                @php
                    $dbfieldselects = [
                        'W_InsPolicy' => 'Policy Number',
                        'W_InsCompany' => 'Insurance Company',
                        'W_Contractor' => 'Case Manager',
                        'W_Owner' => 'Assigned To',
                        'W_PolicyNo' => 'Case # / Member #',
                        'Requestor.R_Company' => 'Requestor Company',
                        'W_Requestor' => 'Requestor Name',
                        'W_Agent' => 'Agent Name',
                        'W_BillCompany' => 'Billing Company',
                        'W_LastName' => 'Applicant Last Name',
                        'W_FirstName' => 'Applicant First Name',
                        'W_DOB' => 'Applicant Date of Birth',
                        'W_SS' => 'Applicant SSN',
                        'W_YearsOfRecord' => 'W_YearsOfRecord',
                        'W_AuthorizedFile' => 'W_AuthorizedFile',
                        'W_Hospital' => 'Hospital Name',
                        'Hospital.H_City' => 'Hospital City',
                        'Hospital.H_State' => 'Hospital State',
                        'Hospital.H_Zip' => 'Hospital Zip Code',
                        'Hospital.H_Phone' => 'Hospital Phone',
                        'Hospital.H_CopyService' => 'Hospital Copy Service',
                    ];
                @endphp
                <x-form.select name="dbfield" label="Field" id="dbfield" :options="$dbfieldselects" empty="-" :default="request('dbfield')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
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

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="dbvalue" label="Value" id="dbvalue" :value="request('dbvalue')" autocomplete="off" maxlength="50" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.input name="W_Hospital" label="Hospital" :value="request('W_Hospital')" autocomplete="off" maxlength="50" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <x-form.select name="W_InsCompany" label="Agency" :options="$agencies" empty="-" :default="request('W_InsCompany')" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="receivedfrom" id="receivedfrom" label="Received From" :value="request('receivedfrom')" type="date" autocomplete="off" min="2015-01-01" max="2030-01-01" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="receivedto" id="receivedto" label="Received To" :value="request('receivedto')" type="date" autocomplete="off" min="2015-01-01" max="2030-01-01" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="completedfrom" id="completedfrom" label="Completed From" :value="request('completedfrom')" type="date" autocomplete="off" min="2015-01-01" max="2030-01-01" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="completedto" id="completedto" label="Completed To" :value="request('completedto')" type="date" autocomplete="off" min="2015-01-01" max="2030-01-01" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="followupfrom" label="Follow up From" :value="request('followupfrom')" type="date" autocomplete="off" min="2015-01-01" max="2030-01-01" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="followupto" label="Follow up To" :value="request('followupto')" type="date" autocomplete="off" min="2015-01-01" max="2030-01-01" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                Workorder Hold<br />
                <x-form.checkbox name="is_hold" id="is_hold" label="On Hold ?" checked="{{ request('is_hold') }}" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                @php
                    $options = [
                        'Additional Facility Information Needed' => 'Additional Facility Information Needed',
                        'Additional Patient Information Needed' => 'Additional Patient Information Needed',
                        'Cancellation Fee Notice' => 'Cancellation Fee Notice',
                        'Fee Approval' => 'Fee Approval',
                        'No Records' => 'No Records',
                        'Other' => 'Other',
                        'Special Authorization Non Prefill' => 'Special Authorization Non Prefill',
                        'Special Authorization Prefill' => 'Special Authorization Prefill',
                        'Special Authorization' => 'Special Authorization',
                    ];
                @endphp
                <x-form.select name="hold_reason" label="Hold Reason" :options="$options" empty="-" :default="request('hold_reason')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                @php
                    $urgentselects = [
                        1 => 'Urgent',
                        0 => 'Not Urgent',
                    ];
                @endphp
                <x-form.select name="W_Urgent" label="Urgent" :options="$urgentselects" empty="-" :default="request('W_Urgent')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                @php
                    $options = [
                        200 => 200,
                        500 => 500,
                        1000 => 1000,
                    ];
                @endphp
                <x-form.select name="limit" label="Results per Page" :options="$options" empty="-" :default="request('limit')" />
            </div>

            <div class="col-4 col-md-4 col-lg-2 pt-2">
                <label>&nbsp; </label>
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.workorders.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-window-close"></i></a>
            </div>

            @if (!empty($workorders) && $usersession['contractor']['accesslevel'] && $usersession['contractor']['C_SysAdmin'])
                <div class="col-4 col-md-4 col-lg-2 pt-2">
                    <label>&nbsp; </label>
                    <br />
                    <a href="{{ route('user.workorders.export', array_merge(request()->query(), ['exporttype' => 'csv'])) }}">Export CSV</a>
                    &nbsp;
                    <a href="{{ route('user.workorders.export', array_merge(request()->query(), ['exporttype' => 'xlsx'])) }}">Export Excel</a>
                </div>
            @endif

        </div>

    </form>

    <br />

    <form method="post" action="{{ route('user.workorders.transfer') }}">

        @if (!empty($workorders))

            @if (!$database)
                @csrf
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-3">
                        <x-form.select name="W_Owner" :options="$contractorsselects" empty="-" required />
                    </div>
                    <div class="col-6 col-md-6 col-lg-3">
                        <x-form.button>Transfer Assigned To</x-form.button>
                    </div>
                </div>

                <br />
            @endif

        @endif

        @if (!empty($workorders))

            @if ($workorders->count() < 200)
                Showing: {{ $workorders->count() }} results
                <div class="p-1">
                </div>
            @endif

            {{ $workorders->withQueryString()->links() }}

            <div class="table-responsive">
                <table class="table table-sm table-hove1r table-striped table-bordered w-auto">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'W_WorkOrder', 'sort_direction' => $sort_direction]) }}">WO</a>
                                <input type="checkbox" onclick="toggle(this);" />
                            </th>
                            <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'age', 'sort_direction' => $sort_direction]) }}">Age</a></th>
                            <th>
                                <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'W_FirstName', 'sort_direction' => $sort_direction]) }}">First</a>
                                <a href="{{ Request::fullUrlWithQuery(['sort_field' => 'W_LastName', 'sort_direction' => $sort_direction]) }}">Last</a>
                                Name
                            </th>
                            <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'W_Hospital', 'sort_direction' => $sort_direction]) }}">Hospital</a></th>
                            <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Hospital_timezone_offset', 'sort_direction' => $sort_direction]) }}">T</a></th>
                            <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'W_Contractor', 'sort_direction' => $sort_direction]) }}">Case Manager</a></th>
                            <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'W_Owner', 'sort_direction' => $sort_direction]) }}">Assigned To</a></th>
                            <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Requestor_R_Company', 'sort_direction' => $sort_direction]) }}">Company</a></th>
                            @if (request('is_hold') == 1)
                                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorderholdtimes.reason', 'sort_direction' => $sort_direction]) }}">Hold Reason</a></th>
                                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorderholdtimes.date_start', 'sort_direction' => $sort_direction]) }}">Hold Start</a></th>
                                <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorderholdtimes.date_start', 'sort_direction' => $sort_direction]) }}">Age</a></th>
                            @endif
                            <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'W_FollowUpStatus', 'sort_direction' => $sort_direction]) }}">Follow up Status</a></th>
                            <th>P</th>
                            <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'W_FollowUpDt', 'sort_direction' => $sort_direction]) }}">Follow up Date</a></th>
                            <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'W_UpdDate', 'sort_direction' => $sort_direction]) }}">Last Update</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workorders as $workorder)
                            <tr>
                                <td>
                                    @if (!$database)
                                        <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}">{{ $workorder->W_WorkOrder }}</a>

                                        <br />
                                        @if ($workorder->W_Status == 'Incomplete')
                                            <input type="hidden" name="Workorder[selected][]" value="0"><input type="checkbox" name="Workorder[selected][]" value="{{ $workorder->W_WorkOrder }}" class="checkboxes">
                                        @endif
                                    @else
                                        <a href="https://{{ $database }}.expressimagingservices.net/user/workorders/{{ $workorder->W_WorkOrder }}" target="_blank">{{ $workorder->W_WorkOrder }}</a>
                                    @endif

                                    {!! Helper::statusesIcons($workorder->W_Status) !!}
                                    {!! Helper::UrgentIcons($workorder->W_Urgent) !!}
                                    <br />
                                    <small>
                                        {{ $workorder->W_ReceiveDate?->format('m/d/Y') }}
                                    </small>

                                </td>
                                <td class="small">
                                    @if ($workorder->W_ReceiveDate)
                                        {{ (int) $workorder->W_ReceiveDate->diffInDays($workorder->W_Status === 'Incomplete' ? now() : $workorder->W_CompletedDate ?? now()) }}
                                    @endif
                                </td>
                                <td>{{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}</td>
                                <td>
                                    @if ($workorder->W_Hospital)
                                        <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" data-bs-title="{{ $workorder->W_Hospital }}<br />{{ $workorder->Hospital_H_Hospital2 }}<br />{{ $workorder->Hospital_H_Phone }}<br />{{ $workorder->Hospital_H_City }} {{ $workorder->Hospital_H_State }}, {{ $workorder->Hospital_H_Zip }}">
                                            {{ $workorder->Hospital_H_Hospital2 ?? null }}
                                        </span>
                                        <br />
                                        {{ $workorder->Hospital_H_State ?? null }}
                                        <br />
                                        @if (!empty($workorder->Hospital_H_Docusign))
                                            <span class="btn btn-xs btn-warning">SARA</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($workorder->Hospital_timezone_offset > '')
                                        {{ date('g:i a', strtotime($workorder->Hospital_timezone_offset . ' hours')) }}
                                    @endif
                                </td>
                                <td>{{ $workorder->W_Contractor }}</td>
                                <td>{{ $workorder->W_Owner }}</td>
                                <td>{{ $workorder->Requestor_R_Company }}</td>
                                @if (request('is_hold') == 1)
                                    <td>{{ $workorder->hold_reason }}</td>
                                    <td nowrap>{{ $workorder->hold_date_start?->format('Y-m-d') }}</td>
                                    <td>{{ (int) $workorder->hold_date_start?->diffInDays($workorder->hold_date_end) ?? 'N/A' }}</td>
                                @endif
                                <td class="small">
                                    @php
                                        $lines = explode("\n", substr($workorder->W_FollowUpStatus ?? '', 0, 100) ?? '');
                                        echo $lines['0'];
                                    @endphp
                                </td>
                                <td nowrap class="small">{{ $workorder->W_ImagePages }}</td>
                                <td nowrap class="small">{{ $workorder->W_FollowUpDt?->format('m/d/Y') }}</td>
                                <td nowrap class="small">{{ $workorder->W_UpdDate?->format('m/d/Y g:i a') }} {{ $workorder->W_UpdDate ? 'pst' : '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $workorders->withQueryString()->links() }}
        @else
            <div class="text-danger">
                use search filter to show data
            </div>
        @endif

    </form>

    <br />
    <br />

</x-user-layout>
