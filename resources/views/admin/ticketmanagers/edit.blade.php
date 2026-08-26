<x-admin-layout>

    <h1>Ticket Manager</h1>

    <br />

    <h2>{{ $ticketmanager->name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.ticketmanagers.update', $ticketmanager->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="name"
                              label="name"
                              :value="old('name', $ticketmanager->name)"
                              required />
                <br />

                <x-form.input name="email"
                              label="Email"
                              :value="old('email', $ticketmanager->email)"
                              required />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />
    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            ticketmanager
            @php dump(@$ticketmanager) @endphp
        </div>
    @endif

</x-admin-layout>
