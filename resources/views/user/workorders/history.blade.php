<x-user-layout title="">

    <h1>Workorder History</h1>

    <br />

    @fragment('workorderhistory')

    <div
        hx-get="/clear"
        hx-target="#workorderhistory"
        hx-trigger="mouseleave delay:100ms"
        hx-swap="innerHTML"
        class="bg-white">

        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>WorkOrder</th>
                    <th>Name</th>
                    <th>Viewed At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workordersessions as $workordersession)
                <tr>
                    <td><a href="{{ route('user.workorders.show', $workordersession['W_WorkOrder']) }}">{{ $workordersession['W_WorkOrder'] }}</a></td>
                    <td>{{ $workordersession['W_FirstName'] }} {{ $workordersession['W_MiddleInit'] }} {{ $workordersession['W_LastName'] }}</td>
                    <td>{{ optional(\Carbon\Carbon::parse($workordersession['viewed_at'] ?? null))->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endfragment

    <br />

</x-user-layout>