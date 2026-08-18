<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Contractor</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.contractors.index') }}" class="btn btn-sm btn-secondary">View Contractors</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.contractors.store') }}">
                @csrf

                <x-form.input name="C_Name" id="C_Name" label="Name" :value="old('C_Name')" onkeyup="this.value = this.value.toUpperCase();" />
                <br />

                <x-form.input name="C_Email" id="C_Email" label="Email" :value="old('C_Email')" />
                <br />

                <x-form.input name="C_Password" id="C_Password" label="Password" :value="old('C_Password')" />
                <br />

                <x-form.select name="C_Location" label="Location" :options="Helper::locations()" empty="-" :default="old('C_Location')" />
                <br />

                @php
                $options = [
                    0 => 'No',
                    1 => 'Yes',
                ];
                @endphp
                <x-form.select name="C_SysAdmin" label="C_SysAdmin" id="C_SysAdmin" :options="$options" :default="old('C_SysAdmin')" />
                <br />

                @php
                    $options = [
                        0 => 'No',
                        1 => 'Yes',
                    ];
                @endphp
                <x-form.select name="C_Caller" label="Caller" id="C_Caller" :options="$options" :default="old('C_Caller')" />
                <br />

                @php
                    $options = [
                        0 => 'No',
                        1 => 'Yes',
                    ];
                @endphp
                <x-form.select name="C_Invoice" label="Invoice" id="C_Invoice" :options="$options" :default="old('C_Invoice')" />
                <br />

                @php
                    $options = [
                        0 => 'Regular User',
                        1 => 'Admin',
                    ];
                @endphp
                <x-form.select name="accesslevel" label="Access Level" id="accesslevel" :options="$options" :default="old('accesslevel')" />
                <br />

                @php
                $options = [
                    0 => 'No',
                    1 => 'Yes',
                ];
                @endphp
                <x-form.select name="is_active" label="Is Active" id="is_active" :options="$options" :default="old('is_active')" />

                <br />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>
