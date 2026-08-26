<x-admin-layout>

    <h1>Create Requestorrole</h1>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.requestorroles.store') }}">
                @csrf

                <x-form.input name="company"
                              id="company"
                              label="company"
                              :value="old('company')"
                              required />
                <br />

                <x-form.input name="name"
                              id="name"
                              label="name"
                              :value="old('name')"
                              required />
                <br />

                <x-form.input name="role"
                              id="role"
                              label="role"
                              :value="old('role')" />
                <br />

                <x-form.checkbox name="active_in_order"
                                 label="Active in Order"
                                 id="active_in_order"
                                 :checked="old('active_in_order', 0)" />
                <x-form.checkbox name="active_in_search"
                                 label="Active in Search"
                                 id="active_in_search"
                                 :checked="old('active_in_search', 0)" />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>
