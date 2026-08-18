<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Edit Copy Service</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.copyservices.index') }}" class="btn btn-sm btn-secondary">View Copy Services</a>
        </div>
    </div>

    <br />

    <h2>{{ $copyservice->C_CopyService }}</h2>

    <br />

    <div class="row">
        <div class="col-md-6">

            <form method="post" action="{{ route('user.copyservices.update', $copyservice->C_ID) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="C_Address" id="C_Address" label="Address" :value="old('C_Address', $copyservice->C_Address)" />
                <br />

                <x-form.input name="C_City" id="C_City" label="City" :value="old('C_City', $copyservice->C_City)" />
                <br />

                <x-form.input name="C_State" id="C_State" label="State" :value="old('C_State', $copyservice->C_State)" />
                <br />

                <x-form.input name="C_Zip" id="C_Zip" label="Zip" :value="old('C_Zip', $copyservice->C_Zip)" />
                <br />

                <x-form.input name="C_Phone" id="C_Phone" label="Phone" :value="old('C_Phone', $copyservice->C_Phone)" />
                <br />

                <x-form.input name="C_Fax" id="C_Fax" label="Fax" :value="old('C_Fax', $copyservice->C_Fax)" />
                <br />

                @if ($subdomain == 'eisdev')

                    <x-form.checkbox name="attestation_required" id="attestation_required" label="Attestation Required" :checked="$copyservice->attestation_required" />
                    <br />

                    <x-form.input name="attestation_file" id="attestation_file" label="Attestation File" :value="old('attestation_file', $copyservice->attestation_file)" />
                    <br />

                    <x-form.input type="date" name="attestation_expiration" label="Attestation Expiration" :value="old('attestation_expiration', $copyservice->attestation_expiration)" />
                    <br />

                @endif

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />

</x-user-layout>