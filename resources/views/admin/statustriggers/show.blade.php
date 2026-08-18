<x-admin-layout title="">

    <h1>Statustrigger</h1>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $statustrigger->ID }}</td>
        </tr>
        <tr>
            <td>WorkOrder</td>
            <td>{{ $statustrigger->WorkOrderNo }}</td>
        </tr>
        <tr>
            <td>Change Type</td>
            <td>{{ $statustrigger->ChangeType }}</td>
        </tr>
        <tr>
            <td>Data</td>
            <td>{!! nl2br($statustrigger->laststatus ?? '') !!}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $statustrigger->CreatedBy }}</td>
        </tr>
        <tr>
            <td>Created</td>
            <td>{{ $statustrigger->Created }}</td>
        </tr>
        <tr>
            <td>Updated</td>
            <td>{{ $statustrigger->Updated }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            statustrigger
            @php dump(@$statustrigger) @endphp
        </div>
    @endif

</x-admin-layout>