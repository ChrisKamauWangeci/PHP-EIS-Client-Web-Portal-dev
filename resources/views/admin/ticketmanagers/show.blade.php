<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Ticket Manager</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.ticketmanagers.index') }}"
               class="btn btn-sm btn-secondary">View Ticket Managers</a>
        </div>
    </div>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>id</td>
            <td>{{ $ticketmanager->id }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $ticketmanager->name }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $ticketmanager->email }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $ticketmanager->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $ticketmanager->updated_at }}</td>
        </tr>
    </table>

    <br />
    <br />
    <h3>Ticket count: {{ $ticketscount }}</h3>

    <br />
    <br />

    <a href="{{ route('admin.ticketmanagers.edit', $ticketmanager->id) }}"
       class="btn btn-sm btn-secondary">Edit</a>

    <br />
    <br />

    @if (!$ticketscount)
        <form method="POST"
              action="{{ route('admin.ticketmanagers.destroy', $ticketmanager->id) }}">
            @csrf
            @method('DELETE')
            <x-form.button class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure?')">Delete</x-form.button>
        </form>
    @endif

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ticketmanager
            @php dump(@$ticketmanager) @endphp
        </div>
    @endif

</x-admin-layout>
