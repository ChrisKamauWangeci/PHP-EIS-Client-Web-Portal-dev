<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Incoming APS Log</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.incoming_aps_logs.index') }}"
               class="btn btn-sm btn-secondary">View Incoming APS Logs</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>id</td>
            <td>{{ $incomingApsLog->id }}</td>
        </tr>
        <tr>
            <td>source</td>
            <td>{{ $incomingApsLog->source }}</td>
        </tr>
        <tr>
            <td>workorder</td>
            <td>{{ $incomingApsLog->workorder }}</td>
        </tr>
        <tr>
            <td>original_file</td>
            <td>{{ $incomingApsLog->original_file }}</td>
        </tr>
        <tr>
            <td>new_file</td>
            <td>{{ $incomingApsLog->new_file }}</td>
        </tr>
        <tr>
            <td>page_count</td>
            <td>{{ $incomingApsLog->page_count }}</td>
        </tr>
        <tr>
            <td>invoice_number</td>
            <td>{{ $incomingApsLog->invoice_number }}</td>
        </tr>
        <tr>
            <td>date_received</td>
            <td>{{ $incomingApsLog->date_received->format('m/d/Y') }}</td>
        </tr>
        <tr>
            <td>created_at</td>
            <td>{{ $incomingApsLog->created_at->format('m/d/Y g:i a') }}</td>
        </tr>
        <tr>
            <td>updated_at</td>
            <td>{{ $incomingApsLog->updated_at->format('m/d/Y g:i a') }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            incomingApsConfig
            @php dump(@$incomingApsLog) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
