<x-admin-layout title="">

    <h1>Workorders Stats</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('admin.workorders.stats') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.datalist name="R_Company"
                                 label="Company"
                                 :options="$companies"
                                 empty="-"
                                 :default="request('R_Company')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="W_Requestor"
                              label="Requestor"
                              id="W_Requestor"
                              :value="request('W_Requestor')"
                              autocomplete="off"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select name="W_Owner"
                               label="Owner"
                               :options="$contractors"
                               empty="-"
                               :default="request('W_Owner')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                @php
                    $options = [
                        'Incomplete' => 'Incomplete',
                        'Complete' => 'Complete',
                        'Cancel' => 'Cancel',
                        'Duplicate' => 'Duplicate',
                        'Delete' => 'Delete',
                    ];
                @endphp
                <x-form.select name="W_Status"
                               label="Status"
                               :options="$options"
                               empty="-"
                               :default="request('W_Status')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                @php
                    $dbfieldselects = [
                        'W_InsCompany' => 'Insurance Company',
                        'W_Contractor' => 'Case Manager',
                        'W_Owner' => 'Assigned To',
                        'Requestor.R_Company' => 'Requestor Company',
                        'W_Hospital' => 'Hospital Name',
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
                @php
                    $options = [
                        '0' => 'Years',
                        '1' => 'Years and Months',
                    ];
                @endphp
                <x-form.select name="display"
                               label="Display"
                               :options="$options"
                               empty="-"
                               :default="request('display')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                @php
                    $options = [
                        '0' => 'Without Status Count',
                        '1' => 'With Status Count',
                    ];
                @endphp
                <x-form.select name="statuses"
                               label="Statuses"
                               :options="$options"
                               empty="-"
                               :default="request('statuses')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                @php
                    $options = array_combine(range(1, 4), range(1, 4));
                @endphp
                <x-form.select name="years"
                               label="Years"
                               :options="$options"
                               empty="-"
                               :default="request('years')" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date"
                              name="receivedfrom"
                              label="Received From"
                              :value="request('receivedfrom')"
                              autocomplete="off"
                              min="{{ now()->subYear(4)->format('Y-m-d') }}"
                              max="{{ now()->addDays(1)->format('Y-m-d') }}" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date"
                              name="receivedto"
                              label="Received To"
                              :value="request('receivedto')"
                              autocomplete="off"
                              min="{{ now()->subYear(4)->format('Y-m-d') }}"
                              max="{{ now()->addDays(1)->format('Y-m-d') }}" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date"
                              name="completedfrom"
                              label="Completed From"
                              :value="request('completedfrom')"
                              autocomplete="off"
                              min="{{ now()->subYear(4)->format('Y-m-d') }}"
                              max="{{ now()->addDays(1)->format('Y-m-d') }}" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input type="date"
                              name="completedto"
                              label="Completed To"
                              :value="request('completedto')"
                              autocomplete="off"
                              min="{{ now()->subYear(4)->format('Y-m-d') }}"
                              max="{{ now()->addDays(1)->format('Y-m-d') }}" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.workorders.stats') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    <br />

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>Year</th>
                    @if ($display)
                        <th>Month</th>
                    @endif
                    @if ($statuses)
                        <th>Incomplete</th>
                        <th>Complete</th>
                        <th>Cancel</th>
                        <th>Duplicate</th>
                        <th>Delete</th>
                    @endif
                    <th>Orders</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workorders as $workorder)
                    <tr>
                        <td>{{ $workorder->year }}</td>
                        @if ($display)
                            <td>{{ $workorder->month }}</td>
                        @endif
                        @if ($statuses)
                            <td>{{ $workorder->count_incomplete }}</td>
                            <td>{{ $workorder->count_complete }}</td>
                            <td>{{ $workorder->count_cancel }}</td>
                            <td>{{ $workorder->count_duplicate }}</td>
                            <td>{{ $workorder->count_delete }}</td>
                        @endif
                        <td>{{ $workorder->counter }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    @if ($display)
                        <td></td>
                    @endif
                    @if ($statuses)
                        <td>{{ $workorders->sum('count_incomplete') }}</td>
                        <td>{{ $workorders->sum('count_complete') }}</td>
                        <td>{{ $workorders->sum('count_cancel') }}</td>
                        <td>{{ $workorders->sum('count_duplicate') }}</td>
                        <td>{{ $workorders->sum('count_delete') }}</td>
                    @endif
                    <td><strong>{{ $workorders->sum('counter') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div>
        <canvas id="chart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($workorders as $workorder)
                        "{{ $workorder->year }} / {{ $workorder->month }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Workorders Stats',
                    data: [
                        @foreach ($workorders as $workorder)
                            {{ $workorder->counter }},
                        @endforeach
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-admin-layout>
