<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Requestor Role</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.requestorroles.index') }}"
               class="btn btn-sm btn-secondary">View Requestor Roles</a>
            <a href="{{ route('admin.requestorroles.show', $requestorrole->id) }}"
               class="btn btn-sm btn-secondary">View Requestor Role</a>
        </div>
    </div>

    <br />

    <h2>{{ $requestorrole->name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.requestorroles.update', $requestorrole->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="company"
                              id="company"
                              label="company"
                              :value="old('company', $requestorrole->company)" />
                <br />

                <x-form.input name="name"
                              id="name"
                              label="name"
                              :value="old('name', $requestorrole->name)" />
                <br />

                <x-form.input name="role"
                              id="role"
                              label="role"
                              :value="old('role', $requestorrole->role)" />
                <br />

                <x-form.checkbox name="active_in_order"
                                 label="Active in Order"
                                 id="active_in_order"
                                 :checked="$requestorrole->active_in_order" />
                <x-form.checkbox name="active_in_search"
                                 label="Active in Search"
                                 id="active_in_search"
                                 :checked="$requestorrole->active_in_search" />

                <br />

                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.requestorroles.index') }}"
                   class="btn btn-sm btn-secondary">Cancel</a>
            </form>

        </div>
    </div>

    <br />
    <br />
    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            requestorrole
            @php dump(@$requestorrole) @endphp
        </div>
    @endif

</x-admin-layout>
