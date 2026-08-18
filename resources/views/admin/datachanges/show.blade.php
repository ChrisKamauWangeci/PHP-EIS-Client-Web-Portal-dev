<x-admin-layout title="">

    <h1>datachange</h1>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $datachange->id }}</td>
        </tr>
        <tr>
            <td>Model</td>
            <td>{{ $datachange->model }}</td>
        </tr>
        <tr>
            <td>Foreign Key</td>
            <td>{{ $datachange->foreign_key }}</td>
        </tr>
        <tr>
            <td>Data</td>
            <td>{!! nl2br($datachange->data) !!}</td>
        </tr>
        <tr>
            <td>Created By</td>
            <td>{{ $datachange->created_by }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $datachange->created_at }}</td>
        </tr>
    </table>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            datachange
            @php dump(@$datachange) @endphp
        </div>
    @endif

    <br />
    <br />

</x-admin-layout>