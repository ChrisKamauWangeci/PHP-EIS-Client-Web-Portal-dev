<x-user-layout title="">


    <div class="row">
        <div class="col-auto">
            <h1>Eisweborder</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.eisweborders.index') }}"
               class="btn btn-sm btn-secondary">View EIS Web Orders</a>
        </div>
    </div>

    <br />

    <table class="table table-sm w-auto">
        <thead>
            <tr>
                <th>Field</th>
                <th>Original Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($eisweborder->getOriginal() as $field => $value)
                <tr>
                    <td>{{ $field }}</td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            eisweborder
            @php dump(@$eisweborder) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
