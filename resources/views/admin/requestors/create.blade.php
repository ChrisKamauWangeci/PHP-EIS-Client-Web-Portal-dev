<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Create Requestor</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.requestors.index') }}" class="btn btn-sm btn-secondary">View Requestors</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.requestors.store') }}">
                @csrf

                <x-form.select name="R_Company" id="R_Company" label="Company Name" :options="$companies" :default="old('R_Company')" />
                <br />

                <x-form.input name="R_Name" id="R_Name" label="Name" :value="old('R_Name')" onkeyup="this.value = this.value.toUpperCase();" />
                <br />

                <x-form.input name="R_Email" id="R_Email" label="Email" :value="old('R_Email')" />
                <br />

                <x-form.input name="R_SSOID" id="R_SSOID" label="SSOID" :value="old('R_SSOID')" />
                <br />

                <x-form.input name="R_LoginEmail" id="R_LoginEmail" label="Login" :value="old('R_LoginEmail')" />
                <br />

                <x-form.input type="password" name="R_Password" id="R_Password" label="Password" :value="old('R_Password')" maxlength="20" />
                <br />

                <x-form.checkbox name="R_Active" id="R_Active" label="Active" :checked="old('R_Active')" />
                <br />

                <x-form.checkbox name="R_SuperUser" id="R_SuperUser" label="SuperUser" :checked="old('R_SuperUser')" />
                <br />

                <x-form.checkbox name="R_ViewRecords" id="R_ViewRecords" label="ViewRecords" :checked="old('R_ViewRecords')" />
                <br />

                <x-form.checkbox name="R_NoOrder" id="R_NoOrder" label="NoOrder" :checked="old('R_NoOrder')" />
                <br />

                <br />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>