<x-user-layout title="Workorder Hold Times">

    <h1>Workorder Hold Times</h1>

    <form method="GET" action="{{ route('user.workorderholdtimes.index') }}">

        <div class="row">

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="workorder_id" label="Workorder ID" :value="request('workorder_id')" autocomplete="off" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.select name="reason" label="Reason" :default="request('reason')" :options="array_combine(Helper::reasons(), Helper::reasons())" autocomplete="off" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="date_start_from" id="date_start_from" label="Date Start From" :value="request('date_start_from')" type="date" autocomplete="off" min="2020-01-01" max="2030-01-01" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="date_start_to" id="date_start_to" label="Date Start To" :value="request('date_start_to')" type="date" autocomplete="off" min="2020-01-01" max="2030-01-01" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="date_end_from" id="date_end_from" label="Date End From" :value="request('date_end_from')" type="date" autocomplete="off" min="2020-01-01" max="2030-01-01" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="date_end_to" id="date_end_to" label="Date End To" :value="request('date_end_to')" type="date" autocomplete="off" min="2020-01-01" max="2030-01-01" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <x-form.input name="created_by" label="Created By" :value="request('created_by')" autocomplete="off" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                @php
                    $selects = [
                        1 => 'Yes',
                        0 => 'No',
                    ];
                @endphp
                <x-form.select name="closed" label="Closed" :options="$selects" empty="-" :default="request('closed')" />
            </div>

            <div class="col-6 col-md-3 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.workorderholdtimes.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $workorderholdtimes->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Workorder ID</th>
                    <th>Hold ID</th>
                    <th>Reason</th>
                    <th>Requirement</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    <th>Age</th>
                    <th>Created By</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workorderholdtimes as $workorderholdtime)
                    <tr>
                        <td>{{ $workorderholdtime->id }}</td>
                        <td>
                            <a href="{{ route('user.workorders.show', $workorderholdtime->workorder_id) }}">{{ $workorderholdtime->workorder_id }}</a>
                        </td>
                        <td>{{ $workorderholdtime->hold_id }}</td>
                        <td>{{ $workorderholdtime->reason }}</td>
                        <td>{{ $workorderholdtime->requirement }}</td>
                        <td>{{ $workorderholdtime->date_start?->format('Y-m-d') }}</td>
                        <td>{{ $workorderholdtime->date_end?->format('Y-m-d') }}</td>
                        <td>{{ (int) $workorderholdtime->date_start?->diffInDays($workorderholdtime->date_end) ?? 'N/A' }}</td>
                        <td>{{ $workorderholdtime->created_by }}</td>
                        <td><a href="{{ route('user.workorderholdtimes.show', $workorderholdtime->id) }}" class="btn btn-xs btn-secondary">view</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $workorderholdtimes->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>
