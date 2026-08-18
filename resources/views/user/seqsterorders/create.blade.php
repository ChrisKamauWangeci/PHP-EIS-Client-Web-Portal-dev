<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Seqster Order</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.seqsterorders.index') }}" class="btn btn-sm btn-secondary">View Seqster Orders</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('user.seqsterorders.store') }}">
                @csrf

                <x-form.input name="project_title" label="Project Title" :value="old('project_title')" />
                <br />

                <x-form.input name="workorder_id" label="Workorder ID" :value="old('workorder_id')" />
                <br />

                <x-form.input name="company" label="Company" :value="old('company')" />
                <br />

                <x-form.input name="first_name" label="First Name" :value="old('first_name')" />
                <br />

                <x-form.input name="last_name" label="Last Name" :value="old('last_name')" />
                <br />

                <x-form.input name="gender" label="Gender" :value="old('gender')" />
                <br />

                <x-form.input name="email" label="Email" :value="old('email')" />
                <br />

                <x-form.input name="birthday" label="Birthday" :value="old('birthday')" />
                <br />

                <x-form.input name="address_1" label="Address 1" :value="old('address_1')" />
                <br />

                <x-form.input name="address_2" label="Address 2" :value="old('address_2')" />
                <br />

                <x-form.input name="city" label="City" :value="old('city')" />
                <br />

                <x-form.input name="state" label="State" :value="old('state')" />
                <br />

                <x-form.input name="postal_code" label="Postal Code" :value="old('postal_code')" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>