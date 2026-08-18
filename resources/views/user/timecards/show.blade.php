<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Time Card</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.timecards.index') }}" class="btn btn-sm btn-secondary">View Timecards</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>Date</td>
            <td>{{ $timecard->work_date->format('m/d/Y') }}</td>
        </tr>
        <tr>
            <td>Clock In</td>
            <td>{{ $timecard->clock_in?->format('g:i A') }}</td>
        </tr>
        <tr>
            <td>Break Start</td>
            <td>{{ $timecard->break_start?->format('g:i A') }}</td>
        </tr>
        <tr>
            <td>Break End</td>
            <td>{{ $timecard->break_end?->format('g:i A') }}</td>
        </tr>
        <tr>
            <td>Clock Out</td>
            <td>{{ $timecard->clock_out?->format('g:i A') }}</td>
        </tr>
        <tr>
            <td>Total Hours</td>
            <td>{{ $timecard->total_hours }}</td>
        </tr>
        <tr>
            <td>Total Minutes</td>
            <td>{{ $timecard->total_minutes }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $timecard->created_at?->format('m/d/Y g:i A') }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $timecard->updated_at?->format('m/d/Y g:i A') }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            alternatepayment
            @php dump(@$alternatepayment) @endphp
        </div>
    @endif

</x-user-layout>