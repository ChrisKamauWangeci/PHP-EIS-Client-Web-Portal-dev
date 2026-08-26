<x-admin-layout title="">

    <h1>Workorders</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.workorders.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="number"
                              name="W_Workorder"
                              label="Workorder ID"
                              :value="request('W_Workorder')"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                @php
                    $statusesselects = [
                        'Incomplete' => 'Incomplete',
                        'Complete' => 'Complete',
                        'Cancel' => 'Cancel',
                        'Duplicate' => 'Duplicate',
                        'Delete' => 'Delete',
                    ];
                @endphp
                <x-form.select name="W_Status"
                               label="Status"
                               :options="$statusesselects"
                               empty="-"
                               :default="request('W_Status')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="W_FirstName"
                              label="First Name"
                              :value="request('W_FirstName')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="W_LastName"
                              label="Last Name"
                              :value="request('W_LastName')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="W_SS"
                              label="Social Security"
                              :value="request('W_SS')"
                              type="number"
                              min="0"
                              max="999999999"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="W_DOB"
                              label="Date of Birth"
                              :value="request('W_DOB')"
                              type="date"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                @php
                    $dbfieldselects = [
                        'W_InsPolicy' => 'Policy Number',
                        'W_InsCompany' => 'Insurance Company',
                        'W_Contractor' => 'Case Manager',
                        'W_Owner' => 'Assigned To',
                        'W_PolicyNo' => 'Case # / Member #',
                        'Requestor.R_Company' => 'Requestor Company',
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
                <x-form.select name="dbfield"
                               label="Field"
                               id="dbfield"
                               :options="$dbfieldselects"
                               empty="-"
                               :default="request('dbfield')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                @php
                    $dbconditionsselects = [
                        'contains' => 'contains',
                        'doesnotcontain' => 'does not contain',
                        'beginswith' => 'begins with',
                        'endswith' => 'ends with',
                        'isequalto' => 'is equal to',
                        'isnotequalto' => 'is not equal to',
                        'isempty' => 'is empty',
                        'isnotempty' => 'is not empty',
                    ];
                @endphp
                <x-form.select name="dbconditions"
                               label="Condition"
                               id="dbconditions"
                               :options="$dbconditionsselects"
                               empty="-"
                               :default="request('dbconditions')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="dbvalue"
                              label="Value"
                              id="dbvalue"
                              :value="request('dbvalue')"
                              autocomplete="off"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="W_Hospital"
                              label="Hospital"
                              :value="request('W_Hospital')"
                              autocomplete="off"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                @php
                    $urgentselects = [
                        1 => 'Urgent',
                        0 => 'Not Urgent',
                    ];
                @endphp
                <x-form.select name="W_Urgent"
                               label="Urgent"
                               :options="$urgentselects"
                               empty="-"
                               :default="request('W_Urgent')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="receivedfrom"
                              label="Received From"
                              :value="request('receivedfrom')"
                              type="date"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="receivedto"
                              label="Received To"
                              :value="request('receivedto')"
                              type="date"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="followupfrom"
                              label="Follow up From"
                              :value="request('followupfrom')"
                              type="date"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="followupto"
                              label="Follow up To"
                              :value="request('followupto')"
                              type="date"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.workorders.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $workorders->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>WorkOrder</th>
                    <th>First Name Middle Init Last Name</th>
                    <th>Hospital</th>
                    <th>Company</th>
                    <th>Contractor</th>
                    <th>Owner</th>
                    <th>Receive Date</th>
                    <th>Completed Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workorders as $workorder)
                    <tr>
                        <td>{{ $workorder->W_WorkOrder }}</td>
                        <td>{{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }} {{ $workorder->W_LastName }}
                        </td>
                        <td>{{ $workorder->W_Hospital }}</td>
                        <td>{{ $workorder->Requestor_R_Company }}</td>
                        <td>{{ $workorder->W_Contractor }}</td>
                        <td>{{ $workorder->W_Owner }}</td>
                        <td>{{ $workorder->W_ReceiveDate?->format('m/d/Y') }}</td>
                        <td>{{ $workorder->W_CompletedDate?->format('m/d/Y') }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.workorders.show', $workorder->W_WorkOrder) }}"
                               class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $workorders->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('admin.workorders.stats') }}"
       class="btn btn-sm btn-secondary">Stats</a>

    <br />
    <br />

</x-admin-layout>
