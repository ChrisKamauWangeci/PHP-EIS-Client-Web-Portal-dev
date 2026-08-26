<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Shelter Agent</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.shelteragents.show', $shelteragent->id) }}"
               class="btn btn-sm btn-secondary">View Shelter Agent</a>
        </div>
    </div>

    <br />

    <h2>{{ $shelteragent->name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-8">

            <form method="post"
                  action="{{ route('admin.shelteragents.update', $shelteragent->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="name"
                              label="Name"
                              :value="old('name', $shelteragent->name)" />
                <br />

                <x-form.input name="email"
                              label="Email"
                              :value="old('email', $shelteragent->email)" />
                <br />

                <x-form.input name="role"
                              label="Role"
                              :value="old('role', $shelteragent->role)" />
                <br />

                <x-form.input name="sdl_district_number"
                              label="SDL District Number"
                              :value="old('sdl_district_number', $shelteragent->sdl_district_number)" />
                <br />

                <x-form.input name="agent_code"
                              label="Agent Code"
                              :value="old('agent_code', $shelteragent->agent_code)" />
                <br />

                <x-form.checkbox name="is_active"
                                 label="Is Active"
                                 :checked="$shelteragent->is_active" />
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
            shelteragent
            @php dump(@$shelteragent) @endphp
        </div>
    @endif

</x-admin-layout>
