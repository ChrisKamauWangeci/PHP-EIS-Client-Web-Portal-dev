<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Statustrigger</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.statustriggers.index') }}" class="btn btn-sm btn-secondary">View Statustriggers</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td nowrap>ID</td>
            <td>{{ $statustrigger->ID }}</td>
        </tr>
        <tr>
            <td nowrap>Workorder</td>
            <td>{{ $statustrigger->WorkOrderNo }}</td>
        </tr>
        <tr>
            <td nowrap>Data</td>
            <td>{!! nl2br($statustrigger->laststatus ?? '') !!}</td>
        </tr>
        <tr>
            <td nowrap>Change Type</td>
            <td>{{ $statustrigger->ChangeType }}</td>
        </tr>
        <tr>
            <td nowrap>Created By</td>
            <td>{{ $statustrigger->CreatedBy }}</td>
        </tr>
        <tr>
            <td nowrap>Created</td>
            <td>{{ $statustrigger->Created }}</td>
        </tr>
        <tr>
            <td nowrap>Updated</td>
            <td>{{ $statustrigger->Updated }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            statustrigger
            @php dump(@$statustrigger) @endphp
        </div>
    @endif


</x-user-layout>