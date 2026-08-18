<x-user-layout title="">

    <style>
        .htmx-indicator {
            opacity: 0;
            transition: opacity 2s ease-in;
        }

        .htmx-request .htmx-indicator {
            opacity: 1;
        }

        .htmx-request.htmx-indicator {
            opacity: 1;
        }

        .flash td {
            animation: flash-bg 2s ease-out;
        }

        @keyframes flash-bg {
            0% {
                background-color: #fff3b0;
            }

            100% {
                background-color: inherit;
            }
        }
    </style>

    <div class="row">
        <div class="col-6">
            <h1>Cancellation Requests</h1>
        </div>
        <div class="col-6 text-end">
        </div>
    </div>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.apscancellations.index') }}">

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="EISWorkOrderID" label="EIS WorkOrder ID" :value="request('EISWorkOrderID')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="CompanyName" label="Company Name" :value="request('CompanyName')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.select name="CancellationStatusID" label="Cancellation Status" :options="$cancellationStatusOptions" empty="-" :default="request('CancellationStatusID')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                @php
                    $notifiedoptions = [
                        '0' => 'Not Completed',
                        '1' => 'Completed',
                    ];
                @endphp
                <x-form.select name="IsNotified" label="Is Completed" :options="$notifiedoptions" empty="-" :default="request('IsNotified')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="Username" label="User Name" :value="request('Username')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                &nbsp;
                <a href="{{ route('user.apscancellations.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />

    {{ $apscancellations->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'EISWorkOrderID', 'sort_direction' => $sort_direction]) }}">EIS WorkOrder ID</a></th>
                    <th>Workorder Status</th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'RequestID', 'sort_direction' => $sort_direction]) }}">Request ID</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'CompanyName', 'sort_direction' => $sort_direction]) }}">Company Name</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'CancellationStatusID', 'sort_direction' => $sort_direction]) }}">Cancellation Status</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'IsNotified', 'sort_direction' => $sort_direction]) }}">Is Completed</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Inserted', 'sort_direction' => $sort_direction]) }}">Requested Date</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Username', 'sort_direction' => $sort_direction]) }}">Username</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apscancellations as $apscancellation)
                    @include('user.apscancellations.partials.row', [
                        'apscancellation' => $apscancellation,
                        'cancellationStatusOptions' => $cancellationStatusOptions,
                    ])
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $apscancellations->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>
