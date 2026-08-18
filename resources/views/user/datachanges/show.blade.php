<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Data Change</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.datachanges.index') }}" class="btn btn-sm btn-secondary">View Data Changes</a>
        </div>
    </div>

    <br />

    <table class="table table-bordered table-sm table-hover w-auto">
        <tr>
            <td>ID</td>
            <td>{{ $datachange->id }}</td>
        </tr>
        <tr>
            <td>Model</td>
            <td>{{ $datachange->model }}</td>
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

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            datachange
            @php dump(@$datachange) @endphp
        </div>
    @endif

</x-user-layout>