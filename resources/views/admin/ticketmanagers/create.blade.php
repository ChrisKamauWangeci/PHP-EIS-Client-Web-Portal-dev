<x-admin-layout>

    <h1>Ticket Manager</h1>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.ticketmanagers.store') }}">
                @csrf

                <x-form.input name="name"
                              label="Name"
                              :value="old('name')"
                              required />
                <br />

                <x-form.input name="email"
                              label="Email"
                              :value="old('email')"
                              required />
                <br />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>
