<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Create Copy Service</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.copyservices.index') }}" class="btn btn-sm btn-secondary">View Copy Services</a>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-md-6">

            <form method="post" action="{{ route('user.copyservices.store') }}">
                @csrf

                <x-form.input name="C_CopyService" id="C_CopyService" label="Copy Service" :value="old('C_CopyService')" required :error="$errors->first('C_CopyService')" />
                <br />

                <x-form.input name="C_Address" id="C_Address" label="Address" :value="old('C_Address')" />
                <br />

                <x-form.input name="C_City" id="C_City" label="City" :value="old('C_City')" />
                <br />

                <x-form.input name="C_State" id="C_State" label="State" :value="old('C_State')" />
                <br />

                <x-form.input name="C_Zip" id="C_Zip" label="Zip" :value="old('C_Zip')" />
                <br />

                <x-form.input name="C_Phone" id="C_Phone" label="Phone" :value="old('C_Phone')" />
                <br />

                <x-form.input name="C_Fax" id="C_Fax" label="Fax" :value="old('C_Fax')" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>
        </div>
    </div>

    <br />

</x-user-layout>