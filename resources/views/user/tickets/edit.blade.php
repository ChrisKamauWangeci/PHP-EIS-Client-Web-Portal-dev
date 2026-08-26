<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Ticket</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.tickets.show', $ticket->id) }}"
               class="btn btn-sm btn-secondary">Show Ticket</a>
            <a href="{{ route('user.tickets.index') }}"
               class="btn btn-sm btn-secondary">View Tickets</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('user.tickets.update', $ticket->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="workorder_id"
                              label="Workorder ID"
                              :value="old('workorder_id', $ticket->workorder_id)" />
                <br />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ticket
            @php dump(@$ticket) @endphp
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
