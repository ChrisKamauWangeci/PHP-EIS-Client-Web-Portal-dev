<x-user-layout title="">

    <h1>Timecards</h1>

    <br />

    <form method="POST" action="{{ route('user.timecards.clockin') }}">
        @csrf
        <button class="btn btn-sm btn-primary">Clock In</button>
    </form>

    <br />

    <form method="POST" action="{{ route('user.timecards.breakstart') }}">
        @csrf
        <button class="btn btn-sm btn-primary">Break Start</button>
    </form>

    <br />

    <form method="POST" action="{{ route('user.timecards.breakend') }}">
        @csrf
        <button class="btn btn-sm btn-primary">Break End</button>
    </form>

    <br />

    <form method="POST" action="{{ route('user.timecards.clockout') }}">
        @csrf
        <button class="btn btn-sm btn-primary">Clock Out</button>
    </form>

    <br />

    <table class="table mt-3">
        <tr>
            <th>Date</th>
            <th>Clock In</th>
            <th>Break Start</th>
            <th>Break End</th>
            <th>Clock Out</th>
            <th>Total in Hours</th>
            <th>Total in Minutes</th>
            <th></th>
        </tr>

        @foreach ($timecards as $card)
        <tr>
            <td>
                {{ $card->work_date->format('m/d/Y') }}
                <br />
                {{ $card->work_date->timezone('Asia/Manila')->format('m/d/Y') }}
            </td>
            <td>
                {{ $card->clock_in?->format('m/d/Y g:i A') }}
                <br />
                {{ $card->clock_in?->timezone('Asia/Manila')->format('m/d/Y g:i A') }}
            </td>
            <td>
                {{ $card->break_start?->format('m/d/Y g:i A') }}
                <br />
                {{ $card->break_start?->timezone('Asia/Manila')->format('m/d/Y g:i A') }}
            </td>
            <td>
                {{ $card->break_end?->format('m/d/Y g:i A') }}
                <br />
                {{ $card->break_end?->timezone('Asia/Manila')->format('m/d/Y g:i A') }}
            </td>
            <td>
                {{ $card->clock_out?->format('m/d/Y g:i A') }}
                <br />
                {{ $card->clock_out?->timezone('Asia/Manila')->format('m/d/Y g:i A') }}
            </td>
            <td>
                {{ $card->total_hours }}
            </td>
            <td>
                {{ $card->total_minutes }}
            </td>
            <td>
                <a href="{{ route('user.timecards.show', $card) }}" class="btn btn-sm btn-warning">Show</a>
                <form method="POST" action="{{ route('user.timecards.destroy', $card) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

</x-user-layout>